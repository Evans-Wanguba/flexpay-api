<?php
namespace EvansWanguba\Flexpay\Contracts;

interface FlexpayClientContract
{
    public function book(array $data): array;
    public function validatePos(array $data): array;
    public function validateOnline(array $data): array;
    public function confirmOtp(array $data): array;
    public function ipn(array $data): array;
}
