<?php

namespace App\Field;

use App\Entity\Reservation;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

final class DateReservationField implements FieldInterface
{
    use FieldTrait;

    public static function new(string $propertyName, ?string $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/field/date_reservation.html.twig')
            ->hideOnForm()
            ->setSortable(true)
            ->formatValue(function ($value, $entity) {
                if ($entity instanceof Reservation) {
                    $date = $entity->getDateReservation();
                    if ($date instanceof \DateTimeInterface) {
                        return $date->format('d/m/Y H:i');
                    }
                }
                return '';
            });
    }
}

