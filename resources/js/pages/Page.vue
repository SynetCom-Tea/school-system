<template>
    <div class="error-container">
      <div class="error-content">
        <div class="error-header">
          <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 16 16" fill="currentColor">
            <path fill-rule="evenodd" d="M8 0a8 8 0 110 16A8 8 0 018 0zm0 1a7 7 0 100 14A7 7 0 008 1zm0 7a1 1 0 00-1 1v4a1 1 0 002 0V9a1 1 0 00-1-1z" clip-rule="evenodd"/>
          </svg>
        </div>
        <div class="error-message">
          <h1>404 - Page not fo</h1>
          <p>The page you were looking for doesn't exist.</p>
          <!-- <router-link to="/">Go back to the homepage</router-link> -->
        </div>
      </div>
    </div>
  </template>
  
  <style scoped>
  .error-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #f6f8fa;
  }
  
  .error-content {
    text-align: center;
    padding: 30px;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .error-header {
    margin-bottom: 20px;
    svg {
      fill: #d73a49;
    }
  }
  
  .error-message {
    h1 {
      font-size: 36px;
      color: #333;
    }
    p {
      font-size: 18px;
      color: #6a737d;
    }
    router-link {
      display: block;
      margin-top: 20px;
      color: #0366d6;
      text-decoration: underline;
    }
  }
  </style>
  