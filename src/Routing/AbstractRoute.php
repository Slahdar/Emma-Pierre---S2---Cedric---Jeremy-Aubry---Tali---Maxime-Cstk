<?php

namespace App\Routing;

abstract class AbstractRoute
{
  protected string $name;
  protected string $path;
  protected array $httpMethods;

  public function __construct(
    string $path,
    array $httpMethods = ["GET"],
    string $name = "default"
  ) {
    $this->path = $path;
    $this->httpMethods = $httpMethods;
    $this->name = $name;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function setName(string $name): self
  {
    $this->name = $name;

    return $this;
  }

  public function getPath(): string
  {
    return $this->path;
  }

  public function setPath(string $path): self
  {
    $this->path = $path;

    return $this;
  }

  public function getHttpMethods(): array
  {
    return $this->httpMethods;
  }

  public function setHttpMethods(array $httpMethods): self
  {
    $this->httpMethods = $httpMethods;

    return $this;
  }
}
