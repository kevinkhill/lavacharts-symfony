# Symfony Bundle for Lavacharts v3.1

## Package Features
- Service locater to retrieve the Lavacharts instance from routes / controllers
- Twig template extensions for easier rendering within views

## For complete documentation, please visit [lavacharts.com](http://lavacharts.com/)

---

## Installing

### Composer
In your project's main ```composer.json``` file, add this line to the requirements:
```json
"khill/lavacharts-symfony": "1.0.*"
```

```bash
$ composer update
```

### Add Bundle
Add the bundle to the AppKernel:
```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Khill\Lavacharts\Symfony\Bundle\LavachartsBundle(),
        );

        // ...
    }

    // ...
}
```
### Import Config
Add the service definition to the ```app/config/config.yml``` file
```yaml
imports:
  # ...
  - { resource: @LavachartsBundle/Resources/config/services.yml
```



# Usage
The creation of charts is separated into two parts:
First, within a route or controller, you define the chart, the data table, and the customization of the output.

Second, within a view, you use one line and the library will output all the necessary javascript code for you.

## Basic Example
Here is an example of the simplest chart you can create: A line chart with one dataset and a title, no configuration.

### Controller
```php
    // Get the lavacharts instance from the container
    $lava = $this->get('lavacharts');

    $data = $lava->DataTable();
    $data->addDateColumn('Day of Month')
         ->addNumberColumn('Projected')
         ->addNumberColumn('Official');

    // Random Data For Example
    for ($a = 1; $a < 30; $a++)
    {
        $rowData = [
          "2016-8-$a", rand(800,1000), rand(800,1000)
        ];

        $data->addRow($rowData);
    }

    $lava->LineChart('Stocks', $data, [
      'title' => 'My Awesome Stocks'
    ])
```

## View
First, pick where the charts will be rendered, into div's with specific IDs
```html
<div id="pages-div"></div>
```

Then, use the twig extensions to render. Each chart has a corresponding twig directive:
```{{ linechart('Stocks', 'stocks-div')|raw }}```


# Changelog
 - 1.0.0
  - Initial Package
