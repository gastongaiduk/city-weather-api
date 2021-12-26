<?php

namespace App\Services\Partners;


abstract class PartnerFactory
{
    public static function make(int $identifier): ?PartnerInterface
    {
        switch ($identifier){
            case TempPartner1::getInternalID():
                $class = new TempPartner1();
                break;
            case TempPartner2::getInternalID():
                $class = new TempPartner2();
                break;
            case TempPartner3::getInternalID():
                $class = new TempPartner3();
                break;
            case TempPartner4::getInternalID():
                $class = new TempPartner4();
                break;
            default:
                $class = null;
        }

        return $class;
    }
}