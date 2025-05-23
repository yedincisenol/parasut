<?php

namespace yedincisenol\Parasut;

interface ParasutInterface
{
    public function setExpiresAt($expiresAt);

    public function setRefreshToken($refreshToken);

    public function setCompanyId($companyId);

    public function setToken($accessToken);

    public function saleInvoice();

    public function product();

    public function tag();

    public function contact();

    public function purchaseBill();

    public function eInvoiceInbox();

    public function eArchive();

    public function eInvoice();

    public function trackable();

    public function category();

    public function account();

    public function me();
}
