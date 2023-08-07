
# Blogify

## Getting Started

### Prerequisites

- Docker
- Makefile

### Installation

1. Clone the repository:

   ```shell
   git clone https://github.com/izemomar/blogify.git
   ```

2. Navigate to the project directory:

   ```shell
   cd <project-directory>
   ```

## Usage

To run the project, perform the following steps:

1. Build the development containers. Please note that when you run this command for the first time, both 'blogify-composer' and 'blogify-npm' containers will take some time to install dependencies. Kindly wait until both mentioned containers are stopped before attempting to access either the client or the API.

   ```shell
   make build.up.dev
   ```

2. Once the database container is up and ready to accept connections, access the API container:

   ```shell
   make it.dev
   ```

3. Inside the API container, run Laravel migrations and seeders:

   ```shell
   php artisan migrate --seed
   ```

4. Inside the API container, you can tests:

   ```shell
   php artisan test
   ```


5. To access the client container simply run:

   ```shell
   make it.dev container="blogify-client"
   ```

 6. The API server will be accessible at `http://localhost:8000`, and the frontend at `http://localhost:3000`.


 ### Note:
 All dependencies will be installed automatically

## Development

During development, you can use the following commands ( make sure that you're in thr root folder):

- Build development containers:

  ```shell
  make build.dev
  ```

- Start the development environment:

  ```shell
  make up.dev
  ```

- Access the API container:

  ```shell
  make it.dev
  ```

- Clear the development environment (including removing volumes and orphan containers):

  ```shell
  make clear.dev
  ```