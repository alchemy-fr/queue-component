# CHANGELOG

## Unreleased
### Added
  - Add `timeout` option to AMQP configuration for consume timeouts

## [0.1.2] - 2016-08-01
### Added
  - Add dependency on psr/log to enable debug logging in queue wrappers
  
### Removed
  - Removed default dead letter exchange parameter value, must be explicitely configured from now on to be enabled
  
## [0.1.1] - 2016-07-29
### Added
  - Add a changelog
  - Add `AmqpFactory::create()` factory method to simplify initialisation

### Fixed
  - Quickstart code sample contained an error

## [0.1.0] - 2016-03-27
### Added
  - First version, compatible with AMQP extension
