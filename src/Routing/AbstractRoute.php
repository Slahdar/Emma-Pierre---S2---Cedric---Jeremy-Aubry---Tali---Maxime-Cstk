<?php

namespace App\Routing;

abstract class AbstractRoute
{
  protected string $name;
  protected string $path;
  protected string $httpMethod;

  public function __construct(
    string $path,
    string $httpMethod = "GET",
    string $name = "default"
  ) {
    $this->path = $path;
    $this->httpMethod = $httpMethod;
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

  public function getHttpMethod(): string
  {
    return $this->httpMethod;
  }

  public function setHttpMethod(string $httpMethod): self
  {
    $this->httpMethod = $httpMethod;

    return $this;
  }
}
