# Task API Documentation

## Overview

This API provides endpoints for managing tasks in a task management system. Each task is associated with a specific user, and users can create, view, edit, delete, and mark tasks as completed.

## Authentication

This API uses JWT (JSON Web Token) for authentication.

- **Obtaining a JWT**: Send a POST request to `/api/login_check` with your username and password to receive a JWT.
- **Using the JWT**: Include the obtained JWT in the Authorization header of your requests. Format: `Authorization: Bearer YOUR_JWT`.

## API Endpoints

### List All Tasks

- **Method**: GET
- **Endpoint**: `/api/tasks`
- **Description**: Retrieves a list of all tasks associated with the authenticated user.
- **Response**: JSON array of tasks.
- **Response Code**: 200 OK

### Create a Task

- **Method**: POST
- **Endpoint**: `/api/task`
- **Description**: Creates a new task for the authenticated user.
- **Request Payload**: JSON object representing `CreateTaskDto` (fields: title, description, etc.).
- **Response**: JSON object of the created task.
- **Response Code**: 200 OK

### Edit a Task

- **Method**: PUT
- **Endpoint**: `/api/task/{id}`
- **Description**: Edits the specified task.
- **URL Parameter**: `id` - The ID of the task to edit.
- **Request Payload**: JSON object representing `EditTaskDto`.
- **Response**: JSON object of the edited task.
- **Response Code**: 200 OK

### Delete a Task

- **Method**: DELETE
- **Endpoint**: `/api/task/{id}`
- **Description**: Deletes the specified task.
- **URL Parameter**: `id` - The ID of the task to delete.
- **Response**: Success message.
- **Response Code**: 200 OK

### Show a Task

- **Method**: GET
- **Endpoint**: `/api/task/{id}`
- **Description**: Retrieves details of the specified task.
- **URL Parameter**: `id` - The ID of the task to retrieve.
- **Response**: JSON object of the requested task.
- **Response Code**: 200 OK

### Mark a Task as Completed

- **Method**: PUT
- **Endpoint**: `/api/task/{id}/completed`
- **Description**: Marks the specified task as completed.
- **URL Parameter**: `id` - The ID of the task to mark as completed.
- **Response**: JSON object of the updated task.
- **Response Code**: 200 OK

## Error Handling

- **400 Bad Request**: Invalid request format or data.
- **401 Unauthorized**: Authentication required or invalid JWT.
- **403 Forbidden**: Access to the requested resource is denied.
- **404 Not Found**: Requested resource not found.
- **500 Internal Server Error**: Unexpected server error.