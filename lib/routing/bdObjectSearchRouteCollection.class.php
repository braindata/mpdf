<?php
/**
 * Description of bdObjectSearchRouteCollection
 *
 * @author Johannes
 */
class bdObjectSearchRouteCollection extends sfObjectRouteCollection
{
  protected
    $routeClass = 'sfDoctrineRoute';

  protected function generateRoutes()
  {
    $this->routes[$this->getRoute('list')] = $this->getRouteForList();
    $this->routes[$this->options['name'].'_filter'] = $this->getRouteForFilter();
    $this->routes[$this->options['name'].'_action'] = $this->getRouteForAction();
  }
  

  protected function getRouteForFilter()
  {
    return new $this->routeClass(
      sprintf('%s/%s', $this->options['prefix_path'], 'filter'),
      array_merge(array('module' => $this->options['module'], 'action' => 'filter', 'sf_format' => 'html'), $this->options['default_params']),
      array_merge($this->options['requirements'], array('sf_method' => 'any')),
      array('model' => $this->options['model'], 'type' => 'object')
    );
  }

  protected function getRouteForAction()
  {
    return new $this->routeClass(
      sprintf('%s/:action/:id', $this->options['prefix_path']),
      array_merge(array('module' => $this->options['module'], 'sf_format' => 'html'), $this->options['default_params']),
      array_merge($this->options['requirements'], array('sf_method' => 'any')),
      array('model' => $this->options['model'], 'type' => 'object', 'method' => $this->options['model_methods']['object'])
    );
  }

}
?>
