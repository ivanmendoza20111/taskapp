<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TicketRepository")
 */
class Ticket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="string", length=10000)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_completado", type="datetime", nullable=true)
     */
    private $fechaCompletado;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="tickets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $usuario;

    /**
     * insversedBy variable nombrada en Entidad Usuario
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="ticketsAsignado")
     */
    private $usuarioAsignado;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=255)
     */
    private $estado;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Ticket
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Ticket
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaCompletado
     *
     * @param \DateTime $fechaCompletado
     *
     * @return Ticket
     */
    public function setFechaCompletado($fechaCompletado)
    {
        $this->fechaCompletado = $fechaCompletado;

        return $this;
    }

    /**
     * Get fechaCompletado
     *
     * @return \DateTime
     */
    public function getFechaCompletado()
    {
        return $this->fechaCompletado;
    }

    /**
     * Set usuarioId
     *
     * @param integer $usuario
     *
     * @return Ticket
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuarioId
     *
     * @return int
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * @return mixed
     */
    public function getUsuarioAsignado()
    {
        return $this->usuarioAsignado;
    }

    /**
     * @param mixed $usuarioAsignado
     */
    public function setUsuarioAsignado($usuarioAsignado)
    {
        $this->usuarioAsignado = $usuarioAsignado;
    }


    /**
     * Set estado
     *
     * @param string $estado
     *
     * @return Ticket
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }
}

