# Plain Toggles Suite Plugin for Kirby CMS

<img src="./.github/screenshot.png" alt="Kirby Toggles Suite">


Extends the [Kirby Toggles Field](https://getkirby.com/docs/reference/panel/fields/toggles) with colors, images and many more.

## Installation

**Manually**

[Download](https://github.com/plain-solutions-gmbh/kirby-toggles-suite) and unzip the content into your plugin folder: `/site/plugins/`

**With Composer**

```bash
composer require plain/kirby-toggles-suite
```

# Examples

## Manual Options

```yaml

label: Theme
type: toggles
options:
  - text: Primary
    value: primary
    color: '#356A86'
  - text: Secondary
    value: secondary
    color: '#D3AF4C'
  - text: Negative
    value: negative
    color: '#FFFFFF'
    background: '#EC5555'
  - text: Positive
    value: positive
    color: '#FFFFFF'
    background: '#A3CD4F'

```


## Query Options

```yml

label: Theme
type: toggles
options:
  type: query
  query: site.colors.tostructure
  text: '{{ item.label }}'
  value: '{{ item.class }}'
  color: '{{ item.invert }}'
  background: '{{ item.default }}'
  icon: alpha

```

# License

Starting with version 1.1.0, this plugin is available under the MIT license.

All customers who purchased this plugin receive support for one year from the date of purchase.
