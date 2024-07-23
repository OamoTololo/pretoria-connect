<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     itemOperations={"get"},
 *     collectionOperations={"get"},
 *     normalizationContext={
 *         "groups"={"read"}
 *     }
 * )
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"read"})
     */
    private ?int $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"read"})
     */
    private ?string $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read"})
     */
    private ?\DateTimeInterface $published;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read"})
     */
    private User $author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VlogPost", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read"})
     */
    private $vlogPosts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPublished(): ?\DateTimeInterface
    {
        return $this->published;
    }

    public function setPublished(\DateTimeInterface $published): self
    {
        $this->published = $published;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User|null $author
     * @return $this
     */
    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return VlogPost
     */
    public function getVlogPosts(): VlogPost
    {
        return $this->vlogPosts;
    }

    /**
     * @param VlogPost $vlogPosts
     * @return $this
     */
    public function setVlogPosts(VlogPost $vlogPosts): self
    {
        $this->vlogPosts = $vlogPosts;

        return $this;
    }
}
