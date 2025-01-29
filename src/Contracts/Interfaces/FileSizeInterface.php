<?php

namespace Abdulbaset\ConvertNumbers\Contracts\Interfaces;

interface FileSizeInterface
{
    public function getFileSizeUnits(): array;
    public function formatFileSize(float $bytes, int $decimals = 2): string;
}