<?php

/*
 * This file was copied from the FOSRestBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file at https://github.com/FriendsOfSymfony/FOSRestBundle/blob/master/LICENSE
 *
 * Original @author Ener-Getick <egetick@gmail.com>
 */

namespace App\Serializer;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Serializes invalid Form instances.
 * todo: rewrite this from scratch.
 */
class FormErrorSerializer
{
    private $translator;

    /**
     * Class constructor.
     *
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * Converts form errors to array.
     *
     * @param FormInterface $data
     *
     * @return array
     */
    public function convertFormToArray(FormInterface $data): array
    {
        $form = $errors = [];

        foreach ($data->getErrors() as $error) {
            $errors[] = $this->getErrorMessage($error);
        }

        if ($errors) {
            $form['errors'] = $errors;
        }

        $children = [];
        foreach ($data->all() as $child) {
            if ($child instanceof FormInterface) {
                $children[$child->getName()] = $this->convertFormToArray($child);
            }
        }

        if ($children) {
            $form['children'] = $children;
        }

        return $form;
    }

    /**
     * @param FormError $error
     *
     * @return string|null
     */
    private function getErrorMessage(FormError $error): ?string
    {
        if (null !== $error->getMessagePluralization()) {
            return $this->translator->transChoice(
                $error->getMessageTemplate(),
                $error->getMessagePluralization(),
                $error->getMessageParameters(),
                'validators'
            );
        }

        return $this->translator->trans(
            $error->getMessageTemplate(),
            $error->getMessageParameters(),
            'validators');
    }
}
