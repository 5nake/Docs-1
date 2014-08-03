<?php
use RuDev\Preview;

class UplFile extends Eloquent
{
    const PERM_PUBLIC  = 1;
    const PERM_PRIVATE = 2;

    protected $table = 'files';
}