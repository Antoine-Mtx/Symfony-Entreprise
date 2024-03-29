<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\EmployeRepository;

/**
 * @ORM\Entity(repositoryClass=EmployeRepository::class)
 */
class Employe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $prenom;

    /**
     * @ORM\Column(type="date")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $ville;

    /**
     * @ORM\Column(type="date")
     */
    private $dateEmbauche;

    /**
     * @ORM\ManyToOne(targetEntity=Entreprise::class, inversedBy="employes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $entreprise;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbEnfants;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(?string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDateEmbauche(): ?\DateTimeInterface
    {
        return $this->dateEmbauche;
    }

    public function setDateEmbauche(\DateTimeInterface $dateEmbauche): self
    {
        $this->dateEmbauche = $dateEmbauche;

        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): self
    {
        $this->entreprise = $entreprise;

        return $this;
    }

    public function getNbEnfants(): ?int
    {
        return $this->nbEnfants;
    }

    public function setNbEnfants(?int $nbEnfants): self
    {
        $this->nbEnfants = $nbEnfants;

        return $this;
    }

    public function __toString()
    {
        return $this->prenom." ".strtoupper($this->nom) ;
    }

    public function getAdresseComplete()
    {
        return $this->adresse." - ".strtoupper($this->cp)." ".strtoupper($this->ville);
    }

    public function getAnciennete()
    {
        $now = new DateTime();
        $anciennete = date_diff($now, $this->dateEmbauche);
        return $anciennete->y." ".(($anciennete->y > 1) ? 'années' : 'année')." et ".$anciennete->m." mois d'ancienneté";
    }

    public function getAge()
    {
        $now = new DateTime();
        $age = date_diff($now, $this->dateNaissance);
        return $age->y." ".(($age->y > 1) ? 'ans' : 'an');
    }

    public function getCollegues()
    {
        return $this->entreprise->getEmployes()->filter( function($employe) {
            return $employe !== $this;
        });
    }
}
