<?php

namespace Bjercke\Language;

use Bjercke\Entity\Language\LanguageString;
use Bjercke\DatabaseManager;
use Bjercke\WebStorage;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;

class Language
{
    private DatabaseManager $db;
    private string $language;

    public function __construct()
    {
        $this->db = DatabaseManager::getInstance();
        $storage = new WebStorage('language');
        $this->language = $storage->getValue();
    }

    /**
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    public function getString(int|string $string): string {
        $em = $this->db->getEntityManager();

        // If the parameter is a string, look for alias. If not, look for id.
        if (is_string($string)) {
            $string = $em->getRepository(LanguageString::class)->findOneBy(['alias' => $string]);
        } else {
            $string = $em->find(LanguageString::class, $string);
        }

        if ($this->getLanguage() === 'en') {
            return $string->getEn();
        }

        if ($this->getLanguage() === 'no') {
            return $string->getNo();
        }

        return $string->getEn();
    }

    public function getLanguageCode($upperCase = false): string {
        if ($upperCase) {
            return strtoupper($this->getLanguage());
        }

        return $this->language;
    }

    public function getOppositeLanguageCode($upperCase = false): string {
        if ($this->getLanguage() === 'en') {
            if ($upperCase) {
                return strtoupper('no');
            }

            return 'no';
        }

        if ($upperCase) {
            return strtoupper('en');
        }

        return 'en';
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }
}