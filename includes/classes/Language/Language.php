<?php

namespace Bjercke\Language;

use Bjercke\Entity\Language\LanguageString;
use Bjercke\DatabaseManager;
use Bjercke\WebStorage;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;
use Exception;

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
     * @throws Exception
     */
    public function getString(int|string $string): string
    {
        $em = $this->db->getEntityManager();

        // If the parameter is a string, look for alias. If not, look for id.
        if (is_string($string)) {
            $result = $em->getRepository(LanguageString::class)->findOneBy(['alias' => $string]);
        } else {
            $result = $em->find(LanguageString::class, $string);
        }

        if ($result === null) {
            if (is_string($string)) {
                throw new Exception("Language string with alias '$string' not found.");
            } else {
                throw new Exception("Language string with ID '$string' not found.");
            }
        }

        if ($this->getLanguage() === 'en') {
            return $result->getEn();
        }

        if ($this->getLanguage() === 'no') {
            return $result->getNo();
        }

        return $result->getEn();
    }

    public function getLanguageCode($upperCase = false): string
    {
        if ($upperCase) {
            return strtoupper($this->getLanguage());
        }

        return $this->language;
    }

    public function getOppositeLanguageCode($upperCase = false): string
    {
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