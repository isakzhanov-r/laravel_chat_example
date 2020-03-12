<template>
    <v-content>
        <v-container
                fill-height
                fluid>
            <v-layout
                    align-center
                    justify-center>
                <v-flex
                        xs12
                        sm8
                        md4>
                    <v-card
                            class="elevation-12">
                        <v-toolbar
                                color="general">
                            <v-toolbar-title>Login Form</v-toolbar-title>
                            <v-spacer/>
                        </v-toolbar>
                        <v-card-text>
                            <v-form >
                                <v-text-field
                                        ref="email"
                                        v-model="form.email"
                                        :error="hasError('email')"
                                        :error-messages="getMessage('email')"
                                        prepend-icon="mdi-email"
                                        label="E-mail"
                                        placeholder="example@gmail.com"
                                        required
                                />
                                <v-text-field
                                        ref="password"
                                        v-model="form.password"
                                        :error="hasError('password')"
                                        :error-messages="getMessage('password')"
                                        :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                                        :type="showPassword ? 'text' : 'password'"
                                        prepend-icon="mdi-lock"
                                        label="Password"
                                        placeholder="*********"
                                        counter
                                        required
                                        @keydown.enter="login"
                                        @click:append="showPassword = !showPassword"
                                />
                            </v-form>
                        </v-card-text>
                        <v-divider class="mt-5"/>
                        <v-card-actions>
                            <v-spacer/>
                            <v-btn
                                    align-center
                                    justify-center
                                    color="general"
                                    @click="login">Login
                            </v-btn>
                        </v-card-actions>
                        <v-snackbar
                                v-model="snackbar"
                                :color="color"
                                :top='true'
                        >
                            {{ errorMessages }}
                            <v-btn
                                    dark
                                    text
                                    @click="snackbar = false"
                            >
                                Close
                            </v-btn>
                        </v-snackbar>
                    </v-card>
                </v-flex>
            </v-layout>

        </v-container>
    </v-content>
</template>

<script>
    import _ from 'lodash';

    export default {
        name: 'Login',
        data:()=>({
            form: {
                email: null,
                password: null,
                remember: true
            },
            errorMessages: 'Incorrect login info',
            snackbar: false,
            color: 'general',
            showPassword: false,
            errors: null
        }),
        methods: {
            hasError(name) {
                return _.has(this.errors, name);
            },
            getMessage(name) {
                return _.get(this.errors, name);
            },
            login: function () {
                this.errors = null;
                this.$axios.post('/api/login', this.form)
                    .then(response => {
                        this.$store.dispatch('auth/Authenticate', {
                            user: response.data
                        });
                        this.$router.push({name: 'home'});
                    })
                    .catch(errors => {
                        this.errors = errors.response.data.errors;
                        this.snackbar= true
                    });
            }
        },
        metaInfo () {
            return {
                title: 'Super Secret | Login'
            }
        }
    };
</script>

<style scoped>

</style>
