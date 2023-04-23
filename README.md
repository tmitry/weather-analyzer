# Hexagonal Architecture, DDD & CQRS built with Symfony 6

## Hexagonal Architecture
Hexagonal Architecture, also known as Ports and Adapters architecture, is a software architecture pattern that separates the core business logic of an application from its external interfaces, such as databases, user interfaces, and messaging systems. This separation allows for greater modularity, flexibility, and testability, as the core logic can be developed and tested independently of the external interfaces.

## Domain-driven design (DDD)
Domain-driven design (DDD) is an approach to software development that emphasizes understanding and modeling the problem domain, as opposed to focusing primarily on technical concerns. It involves collaboration between domain experts and developers to create a shared understanding of the domain, which is then reflected in the software design. DDD aims to create software that is both more closely aligned with the business needs and more maintainable and extensible over time.

## Command and Query Responsibility Segregation (CQRS)
Command and Query Responsibility Segregation (CQRS) is a software architecture pattern that separates the responsibility of handling commands that modify data from the responsibility of handling queries that retrieve data. In a CQRS system, commands and queries are processed by separate components, with different data storage mechanisms optimized for each. This separation can result in increased scalability and performance, as the data access and processing can be optimized for each type of operation.