<template>
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img
          src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid"
          alt="Sample image"
        />
      </div>
      <div class="col-md-6">
        <div class="login-form">
          <h1 class="text-center">Se connecter</h1>
          <form>
            <!-- Email input -->
            <div class="form-group">
              <label for="email">Adresse email</label>
              <input
                type="email"
                id="email"
                class="form-control"
                v-model="data.email"
                placeholder="Email..."
              />
            </div>

            <!-- Password input -->
            <div class="form-group">
              <label for="password">Mot de passe</label>
              <input
                type="password"
                id="password"
                class="form-control"
                v-model="data.password"
                placeholder="Mot de passe..."
              />
            </div>

            <div class="text-center mt-4">
              <button
                type="button"
                class="btn btn-primary"
                :disabled="isLogging"
                :loading="isLogging"
                @click="login"
              >
                {{ isLogging ? "Logging..." : "Login" }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            data: {
                email: "",
                password: "",
            },
            isLogging: false,
        };
    },
    methods: {
        async login() {
            if (this.data.email.trim() == "")
                return this.e("Email requis");
            if (this.data.password.trim() == "")
                return this.e("Mot de passe requis");

            if (this.data.password.length < 6)
                return this.e("Les informations de connexion sont incorrectes. Veuillez réessayer.");

            this.isLogging = true;
            const res = await this.callApi(
                "post",
                "/app/admin_login",
                this.data
            );
            if (res.status == 200) {
                this.s(res.data.msg);
                window.location = "/releves";
            } else if (res.status == 422) {
                for (let i in res.data.errors) {
                    this.e(res.data.errors[i][0]);
                }
            } else {
                if (res.status == 401) {
                    this.i(res.data.msg);
                } else {
                    this.swr();
                }
            }
            this.isLogging = false;
        },
    },
};
</script>

<style scoped>
.container {
  margin-top: 150px;
}

.login-form {
  margin: 0 auto;
  max-width: 400px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.login-form h1 {
  margin-bottom: 25px;
}
</style>