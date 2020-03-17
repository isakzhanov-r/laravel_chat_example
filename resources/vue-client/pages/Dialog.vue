<template>
    <v-container fill-height fluid grid-list-xl class="footer-absolute opacity">
        <v-layout justify-center wrap>
            <v-flex xs9 order-lg2>
                <v-card>
                    <v-card-text>
                        <div class="chat">
                            <v-card-title v-if="contact">{{ contact.name }}</v-card-title>
                            <div class="chat--box">
                                <!--chat Row -->
                                <ul class="chat--list">
                                    <!--chat Row -->
                                    <li v-for="message in messages"
                                        class="chat--item"
                                        :class="message.from == contact.id ?'even': ' odd' ">
                                        <div class="chat--img">
                                            <!--                                            <img src="" alt="user"/>-->
                                        </div>
                                        <div class="chat--content">
                                            <div class="box bg-light-success">
                                                {{ message.message }}
                                            </div>
                                        </div>
                                        <div class="chat--time">----</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-row no-gutters>
                            <v-col cols="12" sm="10">
                                <v-textarea
                                        v-model="input_message"
                                        :value="input_message"
                                        class="mx-2"
                                        label="message"
                                        rows="1"
                                ></v-textarea>
                            </v-col>
                            <v-col cols="12" sm="2">
                                <v-btn class="ma-2" outlined fab color="teal" @click="sendMessage">
                                    <v-icon>mdi-send</v-icon>
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs3 order-lg2>
                <v-card>
                    <v-card-text>
                        emojis
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import _ from 'lodash';

    export default {
        name: 'Dialog',
        data: () => ({
            input_message: ''
        }),
        computed: {
            user() {
                return this.$store.getters['auth/user'];
            },
            contacts() {
                return this.$store.getters['contacts/contacts'];
            },
            contact() {
                return _.find(this.contacts, contact => {
                    return contact.id === parseInt(this.$route.params.contact_id);
                });
            },
            messages() {
                let messages = this.$store.getters['messages/messages'];
                return _.filter(messages, message => {
                    return message.from === this.contact.id || message.from === this.user.id ;
                });
            }
        },
        watch: {
            contact(contact) {
                this.$store.dispatch('messages/getMessages', {contact});
            }
        },
        methods: {
            sendMessage() {
                this.$axios.post('/api/to/' + this.contact.id + '/messages',
                    {message: this.input_message})
                    .then((response) => {
                        this.$store.commit('messages/addMessages', {message: response.data.data});
                    });
            }
        }
    };
</script>

<style lang="scss">
    .opacity {
        opacity: 0.6;
    }

    .chat {
        position: relative;
        overflow: hidden;
        width: auto;
        height: 600px;

        &--box {
            overflow: hidden;
            width: auto;
            height: 600px;
        }

        &--list {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            overflow-y: scroll;
            height: 100%;
            padding-bottom: 40px;
        }

        &--item {
            list-style: none;
            margin-top: 30px;
            display: flex;

            &.odd {
                align-self: flex-end;

                .chat-content {
                    text-align: right;
                    width: calc(100% - 90px);
                }

                .box {
                    clear: both;
                }
            }

            &.odd + .odd {
                margin-top: 0;

                .chat--img img {
                    display: none;
                }
            }

            &.even + .even {
                margin-top: 0;

                .chat--img img {
                    display: none;
                }
            }

            &.reverse {
                text-align: right;

                .chat-time {
                    text-align: left;
                }

                .chat-content {
                    padding-left: 0;
                    padding-right: 15px;
                }
            }
        }

        &--img {
            display: inline-block;
            width: 45px;
            vertical-align: top;

            img {
                width: 45px;
                border-radius: 100%;
            }
        }

        &--content {
            width: calc(100% - 140px);
            display: inline-block;
            padding-left: 15px;

            .box {
                display: inline-block;
                margin-bottom: 10px;
            }
        }

        &--time {
            display: inline-block;
            text-align: right;
            width: 80px;
            font-size: 13px;
            color: #99ABB4;
        }

        .bg-light-success {
            color: black;
            background-color: #CFECFE;
        }

        .box {
            border-radius: 4px;
            padding: 10px;
        }
    }
</style>
