<?php

namespace Bjercke\Language;

use Bjercke\Entity\Language\LanguageString;
use Bjercke\SqlConnection;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\TransactionRequiredException;

class Language
{
    private SqlConnection $db;
    private string $language;

    public function __construct()
    {
        $this->db = SqlConnection::getInstance();
        $this->language = $_SESSION['language'] ?? null;
    }

    /**
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @throws ORMException
     */
    public function getString(int|null $stringId, string|null $alias = null): string {
        $em = $this->db->getEntityManager();

        if ($alias !== null) {
            $string = $em->getRepository(LanguageString::class)->findOneBy(['alias' => $alias]);
        } else {
            $string = $em->find(LanguageString::class, $stringId);
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