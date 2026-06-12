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
      - Provider caching
      - Facade support
      - Eager loading
      - Lazy loading
 - **Fully tested codebase:** The codebase is fully tested  using the [Pest PHP](https://pestphp.com/) testing framework. You can see all tests by going [here](https://github.com/Framework-Factory/core/tree/main/tests).

### Documentation
> All documentation is provided in a [separate repository](https://github.com/Framework-Factory/docs).

#### License
BSD 3-Clause License

Copyright (c) 2026, Framework-Factory

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:

1. Redistributions of source code must retain the above copyright notice, this
   list of conditions and the following disclaimer.

2. Redistributions in binary form must reproduce the above copyright notice,
   this list of conditions and the following disclaimer in the documentation
   and/or other materials provided with the distribution.

3. Neither the name of the copyright holder nor the names of its
   contributors may be used to endorse or promote products derived from
   this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.