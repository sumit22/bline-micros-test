## **Documentation: API Gateway with Kong for `user-service`**

### **1. Introduction to Kong API Gateway**

Kong is an open-source API gateway and microservices management layer. It acts as a **reverse proxy**, routing client requests to the appropriate backend services. It also provides a wide range of built-in plugins for functionalities such as authentication, rate limiting, logging, and traffic control.

#### **Why Use Kong?**

1. **Centralized API Management**:
   - Kong manages multiple microservices in a centralized way, handling tasks like routing, load balancing, and monitoring.
2. **Scalability**:
   - Kong is built to handle a high volume of requests with low latency, making it suitable for production environments.
3. **Extensibility**:
   - With a rich set of plugins, Kong offers built-in features for security, analytics, logging, and transformations.
4. **Flexibility**:
   - It supports a wide range of protocols (HTTP, HTTPS, gRPC, etc.) and can easily integrate with different services and authentication mechanisms.

### **2. Configuring `user-service` in Kong**

To add the `user-service` to Kong, you can use the following configuration steps:

#### **Step 1: Create the Service**

```bash
curl -i -X POST http://localhost:8001/services \
  --data "name=user-service" \
  --data "url=http://user-service:8080"
```

- **`name`**: The name of the service (`user-service`).
- **`url`**: The URL where the `user-service` is hosted.

This step registers the `user-service` with Kong, making it aware of the backend service.

#### **Step 2: Create a Route for the Service**

```bash
curl -i -X POST http://localhost:8001/services/user-service/routes \
  --data "paths[]=/user-service"
```

- **`paths[]`**: The URL path that clients will use to access the `user-service` through Kong.

This step creates a route so that requests to `http://localhost:8000/user-service/*` are forwarded to the backend `user-service`.

### **3. Enabling Key-Based Authentication (Key-Auth Plugin)**

Kong provides several authentication plugins. In this example, we use the **Key-Auth** plugin for simple API key-based authentication.

#### **Step 3: Enable Key-Auth Plugin**

```bash
curl -i -X POST http://localhost:8001/services/user-service/plugins \
  --data "name=key-auth"
```

- **`name`**: The name of the plugin to enable (`key-auth`).

This step enables the Key-Auth plugin, requiring clients to include a valid API key in their requests to access the `user-service`.

#### **Step 4: Create a Consumer**

A **consumer** represents a client application or user who will be authenticated using the API key.

```bash
curl -i -X POST http://localhost:8001/consumers \
  --data "username=user-service-consumer"
```

- **`username`**: The username of the consumer (`user-service-consumer`).

#### **Step 5: Generate an API Key for the Consumer**

```bash
curl -i -X POST http://localhost:8001/consumers/user-service-consumer/key-auth \
  --data "key=b63d5a16-c20d-41b5-94d8-3d66a6490c95"
```

- **`key`**: The API key that clients must include in their requests.

### **4. How to Use Key-Based Authentication**

To access the `user-service` with Key-Auth enabled, clients must include the API key in the `Authorization` header:

```bash
curl -i -X GET http://localhost:8000/user-service/users \
  -H "Authorization: Bearer b63d5a16-c20d-41b5-94d8-3d66a6490c95"
```

The request will be forwarded to the backend service only if the provided API key is valid.

### **5. Why Use Key-Based Authentication (Key-Auth)?**

Key-Auth is a simple and effective way to secure API endpoints using API keys. It is particularly useful for:

1. **Simplicity**:
   - Easy to implement and manage for services that do not require complex authentication.
2. **Security**:
   - Provides a basic layer of security by requiring a valid API key for access.
3. **Compatibility**:
   - Works well for internal services, machine-to-machine communication, or when clients cannot support more complex authentication mechanisms.

### **6. Switching to a Different Authentication Mechanism**

Kong's plugin architecture allows you to easily switch from Key-Auth to other authentication methods without modifying your backend services.

#### **Alternative Authentication Options in Kong**:

1. **JWT (JSON Web Token)**:
   - Supports token-based authentication using signed JWTs.
   - Ideal for stateless, scalable authentication.

   ```bash
   curl -i -X POST http://localhost:8001/services/user-service/plugins \
     --data "name=jwt"
   ```

2. **OAuth2**:
   - Supports OAuth2 authorization, providing a more secure and standardized way to authenticate clients.
   - Suitable for third-party integrations and delegated access.

   ```bash
   curl -i -X POST http://localhost:8001/services/user-service/plugins \
     --data "name=oauth2" \
     --data "config.enable_authorization_code=true"
   ```

3. **Basic Authentication**:
   - Requires clients to provide a username and password.
   - Useful for simple, low-security scenarios.

   ```bash
   curl -i -X POST http://localhost:8001/services/user-service/plugins \
     --data "name=basic-auth"
   ```

### **Steps to Migrate from Key-Auth to JWT or OAuth2**:

1. **Disable Key-Auth Plugin**:

   ```bash
   curl -i -X DELETE http://localhost:8001/services/user-service/plugins/<key-auth-plugin-id>
   ```

2. **Enable the New Authentication Plugin**:
   - Enable JWT, OAuth2, or another authentication method using the appropriate configuration.

3. **Test the New Authentication**:
   - Ensure the new authentication method works as expected before fully switching clients to use it.

### **7. Summary**

Using Kong as an API gateway provides a flexible, scalable, and secure way to manage your microservices. The Key-Auth plugin offers a straightforward approach to secure your services, but Kong's extensible plugin system allows you to easily switch to more advanced authentication mechanisms like JWT or OAuth2 as your needs evolve.

By centralizing authentication and API management with Kong, you reduce the complexity in your microservices and gain the ability to apply consistent security policies across your entire architecture.