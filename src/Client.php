<?php

namespace yedincisenol\Parasut;

use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\StreamInterface;
use yedincisenol\Parasut\Exceptions\AccountExpiredException;
use yedincisenol\Parasut\Exceptions\NotFoundException;
use yedincisenol\Parasut\Exceptions\ParasutException;
use yedincisenol\Parasut\Exceptions\ToManyRequestException;
use yedincisenol\Parasut\Exceptions\UnauthenticatedException;
use yedincisenol\Parasut\Exceptions\UnproccessableEntityException;
use yedincisenol\Parasut\Models\Account;
use yedincisenol\Parasut\Models\Category;
use yedincisenol\Parasut\Models\Contact;
use yedincisenol\Parasut\Models\EArchive;
use yedincisenol\Parasut\Models\EInvoice;
use yedincisenol\Parasut\Models\EInvoiceInbox;
use yedincisenol\Parasut\Models\Me;
use yedincisenol\Parasut\Models\PurchaseBill;
use yedincisenol\Parasut\Models\SaleInvoice;
use yedincisenol\Parasut\Models\Tag;
use yedincisenol\Parasut\Models\Trackable;
use yedincisenol\Parasut\Models\Product;

class Client
{

    /**
     * The base api url.
     *
     * @return string
     */
    const API_URL = 'https://api.parasut.com/v4/';

    /**
     * The oAuth token url.
     *
     * @var string
     */
    const API_TOKEN_URL = 'https://api.parasut.com/oauth/token';

    /**
     * The base api url for stage.
     *
     * @return string
     */
    const STAGE_API_URL = 'https://api.heroku-staging.parasut.com/v4/';

    /**
     * The oAuth token url for stage.
     *
     * @var string
     */
    const STAGE_API_TOKEN_URL = 'https://api.heroku-staging.parasut.com/oauth/token';

    /**
     * Parasut connection config
     * @var array
     */
    private $config = [
        'client_id'     => null,
        'client_secret' => null,
        'redirect_uri'  => null,
        'username'      => null,
        'password'      => null,
        'company_id'    => null
    ];

    /**
     * Users access token
     * @var
     */
    private $accessToken = null;

    /**
     * Refresh token
     * @var null
     */
    private $refreshToken = null;

    /**
     * Token expires at
     * @var null
     */
    private $expiresAt = null;

    /**
     * @var bool
     */
    private $isStage = false;

    /**
     * Redirect url
     * @var null $redirectUri
     */
    private $redirectUri = null;

    /**
     * GuzzleHttp client
     * @var null
     */
    private $client = null;

    /**
     * Client constructor.
     * @param $clientID
     * @param $clientSecret
     * @param $redirectUri
     * @param $username
     * @param $password
     * @param $companyID
     * @param bool $isStage
     */
    public function __construct(
        $clientID,
        $clientSecret,
        $redirectUri,
        $username,
        $password,
        $companyID,
        $isStage = false
    ) {
        $this->config = [
            'client_id'     => $clientID,
            'client_secret' => $clientSecret,
            'redirect_uri'  => $redirectUri,
            'username'      => $username,
            'password'      => $password,
            'company_id'    => $companyID
        ];

        $this->isStage = $isStage;
        $this->setRedirectUri($redirectUri);
    }

    /**
     * Set redirect uri
     * @param $redirectUri
     */
    public function setRedirectUri($redirectUri)
    {
        $this->redirectUri = $redirectUri;
    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * Set users access token
     * @param $accessToken
     * @return $this
     */
    public function setToken($accessToken)
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    /**
     * Set access token
     * @param $token
     */
    public function setRefreshToken($token)
    {
        $this->refreshToken = $token;
    }

    /**
     * Set expires at
     * @param $expiresIn
     */
    public function setExpiresAt($expiresIn)
    {
        $this->expiresAt = strtotime('-10 minutes') + $expiresIn;
    }

    /**
     * Set company id
     * @param integer $companyId
     */
    public function setCompanyId($companyId)
    {
        $this->config['company_id'] = $companyId;
    }

    /**
     * Login and fill credentials
     */
    public function login()
    {
        $token = $this->guzzleClient()->post($this->getTokenBaseUrl(), [
            'form_params' => [
                'grant_type'    => 'password',
                'client_id'     => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'username'      => $this->config['username'],
                'password'      => $this->config['password'],
                'redirect_uri'  => $this->getRedirectUri()
            ]
        ]);

        $token = $this->toArray($token->getBody());
        $this->setToken($token['access_token']);
        $this->setRefreshToken($token['refresh_token']);
        $this->setExpiresAt($token['expires_in']);

        return $this;
    }

    /**
     * Refresh token
     */
    public function refresh()
    {
        $token = $this->guzzleClient()->post($this->getTokenBaseUrl(), [
            'form_params' => [
                'grant_type'    => 'refresh_token',
                'client_id'     => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'redirect_uri'  => $this->getRedirectUri(),
                'refresh_token' => $this->refreshToken
            ]
        ]);

        $token = $this->toArray($token->getBody());
        $this->setToken($token['access_token']);
        $this->setRefreshToken($token['refresh_token']);
        $this->setExpiresAt($token['expires_in']);

        return $this;
    }

    /**
     * Get token by authorization code
     * @param $code
     * @return Client
     */
    public function code($code)
    {
        $token = $this->guzzleClient()->post($this->getTokenBaseUrl(), [
            'form_params' => [
                'grant_type'    => 'authorization_code',
                'client_id'     => $this->config['client_id'],
                'client_secret' => $this->config['client_secret'],
                'redirect_uri'  => $this->getRedirectUri(),
                'code' => $code
            ]
        ]);

        $token = $this->toArray($token->getBody());
        $this->setToken($token['access_token']);
        $this->setRefreshToken($token['refresh_token']);
        $this->setExpiresAt($token['expires_in']);

        return $this;
    }

    /**
     * @return \GuzzleHttp\Client
     */
    private function guzzleClient()
    {
        return new \GuzzleHttp\Client([
            'base_url' => $this->getTokenBaseUrl()
        ]);
    }

    /**
     * Get users access token
     * @return mixed
     */
    public function getToken()
    {
        return $this->accessToken;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @return null
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Get company id
     * @return integer Company id
     */
    public function getCompanyId()
    {
        return $this->config['company_id'];
    }

    /**
     * Response to array
     * @param StreamInterface $response
     * @return mixed
     */
    public function toArray(StreamInterface $response)
    {
        return json_decode((string) $response, true);
    }

    /**
     * @return string
     */
    private function getTokenBaseUrl()
    {
        if ($this->isStage) {
            return self::STAGE_API_TOKEN_URL;
        }

        return self::API_TOKEN_URL;
    }

    /**
     * Get guzzle client;
     * @param $appendCompanyId
     * @return \GuzzleHttp\Client
     */
    public function getClient($appendCompanyId)
    {
        $this->client = new \GuzzleHttp\Client([
            'base_uri' => $this->getBaseUrl($appendCompanyId),
            'headers'  => [
                'Authorization' => $this->getAuth(),
                'Content-type'  => 'application/json; charset=utf-8',
            ]
        ]);

        return $this->client;
    }

    /**
     * Send a request
     * @param $method
     * @param $path
     * @param array $query
     * @param array $body
     * @param bool $appendCompanyId
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $path, $query = [], $body = [], $appendCompanyId = true)
    {
        $response = null;
        $body = json_encode($body);
        try {
            $response = $this->getClient($appendCompanyId)->request($method, $path, [
                'body'  => $body,
                'query' => $query,
            ]);

            return $response;
        } catch (ClientException $e) {
            $this->errorHandler($e);
        }

        return $response;
    }

    /**
     * Handle paraşüt errors
     * @param RequestException $e
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     */
    private function errorHandler(RequestException $e)
    {
        $responseBody = (string) $e->getResponse()->getBody();
        $statusCode = $e->getResponse()->getStatusCode();
        switch ($statusCode) {
            case 401:
                throw new UnauthenticatedException($responseBody, $statusCode);
            case 402:
                throw new AccountExpiredException($responseBody, $statusCode);
                break;
            case 422:
                throw new UnproccessableEntityException($responseBody, $statusCode);
                break;
            case 404:
                throw new NotFoundException($responseBody . ' - Not Found', $statusCode);
                break;
            case 429:
                throw new ToManyRequestException($responseBody, $statusCode);
                break;
            case 500:
                throw new ParasutException('Server Error', 500);
                break;
            default:
                throw new ParasutException($responseBody, $statusCode);
                break;
        }
    }

    /**a
     * Get auth
     * @return string
     */
    private function getAuth()
    {
        return 'Bearer ' . $this->getToken();
    }

    /**
     * Get base url of API
     * @param $appendCompanyId
     * @return string
     */
    private function getBaseUrl($appendCompanyId)
    {
        $url = $this->isStage ? self::STAGE_API_URL : self::API_URL;
        return $url . ($appendCompanyId ? $this->config['company_id'] . '/' : '');
    }

    /**
     * @param $path
     * @param $parameters
     * @return \Psr\Http\Message\StreamInterface
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($path, $parameters)
    {
        return $this->request('GET', $path, $parameters);
    }

    /**
     * Make create request
     * @param $path
     * @param $request
     * @return StreamInterface
     * @throws NotFoundException
     * @throws ParasutException
     * @throws UnproccessableEntityException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($path, $request)
    {
        return $this->request('POST', $path, [], $request);
    }

    /**
     * Get SaleInvoice model
     * @return SaleInvoice
     */
    public function saleInvoice()
    {
        return new SaleInvoice($this);
    }

    /**
     * Get Product model
     * @return Product
     */
    public function product()
    {
        return new Product($this);
    }

    /**
     * Get tag object
     * @return Tag
     */
    public function tag()
    {
        return new Tag($this);
    }

    /**
     * Get a Contact object
     * @return Contact
     */
    public function contact()
    {
        return new Contact($this);
    }

    /**
     * Get a Purchase Bill object
     * @return PurchaseBill
     */
    public function purchaseBill()
    {
        return new PurchaseBill($this);
    }

    /**
     * Get EInvoice object
     * @return EInvoiceInbox
     */
    public function eInvoiceInbox()
    {
        return new EInvoiceInbox($this);
    }

    /**
     * E-Archive object
     * @return EArchive
     */
    public function eArchive()
    {
        return new EArchive($this);
    }

    /**
     * Get E-Invoice object
     * @return EInvoice
     */
    public function eInvoice()
    {
        return new EInvoice($this);
    }

    /**
     * Get Trackable object
     * @return Trackable
     */
    public function trackable()
    {
        return new Trackable($this);
    }

    /**
     * Get Category object
     * @return Category
     */
    public function category()
    {
        return new Category($this);
    }

    /**
     * Get Account object
     *
     * @return Account
     */
    public function account()
    {
        return new Account($this);
    }

    /**
     * Get Me object
     *
     * @return Me
     */
    public function me()
    {
        return new Me($this);
    }
}
