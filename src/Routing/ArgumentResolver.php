<?php

namespace App\Routing;

class ArgumentResolver
{
  /**
   * Checks if given URL matches given route
   *
   * @param string $url
   * @param Route $route
   * @return boolean
   */
  public function match(string $url, Route $route): bool
  {
    return preg_match($route->getRegex(), $url) === 1;
  }

  /**
   * Extract the GET params from the URL and build an array containing these params.
   *
   * @param string $url
   * @param Route $route
   * @return array Associative arrays containing route parameters names as keys and URL provided values as values
   */
  public function resolveUrlParams(string $url, Route $route): array
  {
    $params = [];

    preg_match($route->getRegex(), $url, $params);

    return array_filter($params, fn ($key) => !is_int($key), ARRAY_FILTER_USE_KEY);
  }
}
