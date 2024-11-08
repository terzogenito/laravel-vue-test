<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="handleLogin">
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" v-model="email" required />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" v-model="password" required />
      </div>

      <button type="submit">Login</button>
      <p v-if="errorMessage" style="color: red;">{{ errorMessage }}</p>
      <p v-if="successMessage" style="color: green;">{{ successMessage }}</p>
    </form>
    <p>Don't have an account? <router-link to="/register">Register here</router-link></p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "", // Add email property
      password: "", // Add password property
      errorMessage: "",
      successMessage: "",
    };
  },
  methods: {
    async handleLogin() {
      try {
        const response = await fetch("http://localhost:8000/api/auth/login", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            email: this.email,
            password: this.password,
          }),
        });

        if (!response.ok) {
          const errorData = await response.json();
          throw new Error(errorData.message || "Login failed");
        }

        const data = await response.json();

        localStorage.setItem("auth_token", data.access_token);

        console.log("Login successful:", data);
        this.successMessage = "Login successful!";
        this.errorMessage = "";

        this.$router.push("/main");
      } catch (error) {
        console.error("Login failed:", error.message);
        this.errorMessage = error.message;
        this.successMessage = "";
      }
    },
  },
};
</script>

<style scoped>
body {
  background: linear-gradient(135deg, #6e8efb, #a777e3);
  font-family: Arial, sans-serif;
  min-height: 100vh;
  margin: 0;
}

.login-container {
  background: #ffffff;
  max-width: 400px;
  width: 90%;
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
  text-align: center;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.login-container h2 {
  margin-bottom: 20px;
  color: #4a4a4a;
  font-weight: bold;
  font-size: 24px;
  letter-spacing: 1px;
}

.form-group {
  margin-bottom: 20px;
  text-align: left;
}

.form-group label {
  font-size: 14px;
  color: #555;
  margin-bottom: 5px;
  display: inline-block;
  font-weight: 600;
}

.form-group input {
  width: 100%;
  padding: 12px 15px;
  font-size: 16px;
  border: 1px solid #ddd;
  border-radius: 8px;
  box-sizing: border-box;
  transition: border-color 0.3s;
}

.form-group input:focus {
  border-color: #6e8efb;
  outline: none;
}

button {
  width: 100%;
  padding: 12px 15px;
  font-size: 16px;
  color: white;
  background: linear-gradient(135deg, #6e8efb, #a777e3);
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: bold;
  transition:
    transform 0.3s,
    box-shadow 0.3s;
  margin-top: 10px;
}

button:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

button:active {
  transform: translateY(0);
  box-shadow: none;
}

.error-message {
  color: #ff4d4d;
  font-size: 14px;
  margin-top: 10px;
}

p {
  font-size: 14px;
  color: #888;
  margin-top: 15px;
}
</style>
