<?php
/**
 * Handle doctrine ORM access to the database table
 *
 * @author hhombergs
 * @category Work
 * @package Flats
 * @subpackage Database
 * @since 2017-08-23
 * @copyright Henz-Gerd Hombergs
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flats
 *
 * @ORM\Table(name="flats", indexes={@ORM\Index(name="token_idx", columns={"token"})})
 * @ORM\Entity
 */
class Flats
{

    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enter_date", type="date", nullable=false, options={"default"="NOW()"})
     */
    private $enterDate;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255, nullable=false, options={"default"="''"})
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="string", length=20, nullable=false, options={"default"="''"})
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false, options={"default"="''"})
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=false, options={"default"="''"})
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_email", type="string", length=255, nullable=false, options={"default"="''"})
     */
    private $contactEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=255, nullable=false, options={"default"="''"})
     */
    private $token;

    /**
     * Get id
     *
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }

    /**
     * Set enterDate
     *
     * @param \DateTime $enterDate
     *
     * @return Flats
     */
    public function setEnterDate($enterDate) : Flats
    {
        $this->enterDate = $enterDate;

        return $this;
    }

    /**
     * Get enterDate
     *
     * @return \DateTime
     */
    public function getEnterDate() : \DateTime
    {
        return $this->enterDate;
    }

    /**
     * Set street
     *
     * @param string $street
     *
     * @return Flats
     */
    public function setStreet($street) : Flats
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet() : string
    {
        return $this->street;
    }

    /**
     * Set zip
     *
     * @param string $zip
     *
     * @return Flats
     */
    public function setZip($zip) : Flats
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip() : string
    {
        return $this->zip;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Flats
     */
    public function setCity($city) : Flats
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity() : string
    {
        return $this->city;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Flats
     */
    public function setCountry($country) : Flats
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry() : string
    {
        return $this->country;
    }

    /**
     * Set contactEmail
     *
     * @param string $contactEmail
     *
     * @return Flats
     */
    public function setContactEmail($contactEmail) : Flats
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string
     */
    public function getContactEmail() : string
    {
        return $this->contactEmail;
    }

    /**
     * Set token
     *
     * @param string $token
     *
     * @return Flats
     */
    public function setToken($token) : Flats
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken() : string
    {
        return $this->token;
    }

}

