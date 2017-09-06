<?php

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
    public function getId()
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
    public function setEnterDate($enterDate)
    {
        $this->enterDate = $enterDate;

        return $this;
    }

    /**
     * Get enterDate
     *
     * @return \DateTime
     */
    public function getEnterDate()
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
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet()
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
    public function setZip($zip)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return string
     */
    public function getZip()
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
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
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
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
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
    public function setContactEmail($contactEmail)
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    /**
     * Get contactEmail
     *
     * @return string
     */
    public function getContactEmail()
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
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

}

