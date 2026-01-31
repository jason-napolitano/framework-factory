# Framework Factory
> Framework Factory is a PHP application starter package. It's inspired by the Laravel framework, without all
> the bells and whistles. At its core is a robust and powerful PSR-11 compatible dependency container. Aside
> from Pest for testing and Pint for formatting it requires no external dependencies and relies strictly on 
> its own built-in, internal libraries.
>
> The aim is to make building a PHP 8 powered application a breeze, by giving a construct for the
> beginning stages of application development. Provided is an application entrypoint interface, and
> the logic needed to get your next project going with minimal boilerplate overhead.
>
> You can see a basic demonstration implementation by visiting the demo repository [here](https://github.com/Framework-Factory/demo).

## Features
 - **Application entrypoint:** The application entrypoint is located at `FrameworkFactory\Application`, and assists in setting up your application by providing a fluent Boostrap API.
 - **PSR-11 IoC Container:** The IoC container is the core and the heart of Framework Factory. It is a powerful container that includes many features for adding dependencies to your application, as well as giving you access to them.
   - **Container Features**:
      - Container lifecycle hooks
      - Context binding support
      - Lazy loaded providers
      - Provider caching
      - Facade support
 - **Fully tested codebase:** The codebase is fully tested  using the [Pest PHP](https://pestphp.com/) testing framework. You can see all tests by going [here](https://github.com/Framework-Factory/core/tree/main/tests).
