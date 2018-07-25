<?php

namespace App\Base\PDF;

abstract class PDFAbstract
{
    protected $paperSize;

    protected $paperOrientation;

    public function __construct()
    {
        $this->paperSize = config('blend.paperSize') ?: 'letter';
        $this->paperOrientation = config('blend.paperOrientation') ?: 'portrait';
    }

    public function setPaperSize($paperSize)
    {
        $this->paperSize = $paperSize;
    }

    public function setPaperOrientation($paperOrientation)
    {
        $this->paperOrientation = $paperOrientation;
    }
}