<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ticket
 *
 * @ORM\Table(name="ticket", indexes={@ORM\Index(name="fk_ticket_usuario", columns={"usuario_id"}), @ORM\Index(name="fk_ticket_usuario_asignado", columns={"usuario_asignado_id"})})
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
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario",inversedBy="tickets")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
     * })
     */
    private $usuario;

    /**
     * @var \Usuario
     *
     * @ORM\ManyToOne(targetEntity="Usuario",inversedBy="ticketsAsignado")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="usuario_asignado_id", referencedColumnName="id")
     * })
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
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Ticket
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;
        return $this;
    }
    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set usuarioAsignado
     *
     * @param \AppBundle\Entity\Usuario $usuarioAsignado
     *
     * @return Ticket
     */
    public function setUsuarioAsignado(\AppBundle\Entity\Usuario $usuarioAsignado = null)
    {
        $this->usuarioAsignado = $usuarioAsignado;
        return $this;
    }
    /**
     * Get usuarioAsignado
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuarioAsignado()
    {
        return $this->usuarioAsignado;
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

