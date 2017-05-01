[![Build Status](https://scrutinizer-ci.com/g/gplcart/faker/badges/build.png?b=master)](https://scrutinizer-ci.com/g/gplcart/faker/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/gplcart/faker/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/gplcart/faker/?branch=master)

Faker a [GpL Cart](https://github.com/gplcart/gplcart) module that allows developers to quickly populate their stores with various random "Lorem Ipsum" data for testing purposes. Based on [Faker](https://github.com/fzaninotto/Faker) library

**Currently supported entities:**

- Address
- Category
- City
- Collection
- Collection item
- Country
- Country state
- Geo zone
- Field
- Field value
- File
- Page
- Product
- Product class
- Review
- Country state
- User

Installation:

1. Download and extract to `system/modules` manually or using composer `composer require gplcart/faker`. IMPORTANT: If you downloaded the module manually, be sure that the name of extracted module folder doesn't contain a branch/version suffix, e.g `-master`. Rename if needed.
2. Go to `admin/module/list` end enable the module
3. Grant permissions `Faker: generate content` at `admin/user/role`
4. Generate fake content at `admin/tool/faker`