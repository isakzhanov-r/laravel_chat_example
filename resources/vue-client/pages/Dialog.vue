<template>
    <v-container fill-height fluid grid-list-xl class="footer-absolute opacity">
        <v-layout justify-center wrap>
            <v-flex md="12" lg="10" order-lg2>
                <v-card>
                    <v-card-text>
                        <div class="chat">
                            <v-card-title v-if="contact">{{ contact.name }}</v-card-title>
                            <div class="chat--box" v-scroll-bottom>
                                <!--chat Row -->
                                <ul class="chat--list" v-for="(message_list, date) in messages">
                                    <li class="text-center">
                                        <v-chip class="ma-2" small>
                                            {{ date | moment('DD.MM.YYYY')}}
                                        </v-chip>
                                    </li>
                                    <!--chat Row -->
                                    <li v-for="message in message_list"
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
                                        <div class="chat--time">{{ message.created_at | moment('HH:MM') }}</div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </v-card-text>
                    <v-card-actions>
                        <v-row no-gutters style="position: relative">
                            <div class="sc-emoji-picker hidden-lg-and-up" v-show="emojiShow">
                                <div class="sc-emoji-picker--content">
                                    <div v-for="category in emojiData" class="sc-emoji-picker--category" :key="category.name">
                                        <div class="sc-emoji-picker--category-title">{{category.name}}</div>
                                        <span
                                                v-for="emoji in category.emojis"
                                                :key="emoji"
                                                class="sc-emoji-picker--emoji"
                                                @click="emojiClicked(emoji)"
                                        >{{emoji}}</span>
                                    </div>
                                </div>
                            </div>
                            <v-col cols="12" sm="10">
                                <v-textarea
                                        @keypress.enter.prevent.exact="sendMessage"
                                        @keydown.ctrl.enter.prevent="newLine"
                                        auto-grow
                                        rows="1"
                                        v-model="input_message"
                                        :value="input_message"
                                        class="chat--textarea mx-2"
                                        label="message"
                                ></v-textarea>
                            </v-col>
                            <v-col cols="12" sm="2">
                                <div class="text-center">
                                    <v-btn class="hidden-lg-and-up" icon @click="emojiShow = !emojiShow">
                                        <v-icon>mdi-apple-finder</v-icon>
                                    </v-btn>
                                    <v-btn class="ma-2" icon color="teal" @click="sendMessage">
                                        <v-icon>mdi-send</v-icon>
                                    </v-btn>
                                </div>
                            </v-col>
                        </v-row>
                    </v-card-actions>
                </v-card>
            </v-flex>
            <v-flex xs3 order-lg2 hidden-md-and-down>
                <v-card>
                    <v-card-text>
                        <div class="sc-emoji-picker desktop">
                            <div class="sc-emoji-picker--content">
                                <div v-for="category in emojiData" class="sc-emoji-picker--category" :key="category.name">
                                    <div class="sc-emoji-picker--category-title">{{category.name}}</div>
                                    <span
                                            v-for="emoji in category.emojis"
                                            :key="emoji"
                                            class="sc-emoji-picker--emoji"
                                            @click="emojiClicked(emoji)"
                                    >{{emoji}}</span>
                                </div>
                            </div>
                        </div>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import _ from 'lodash';
    import emojiData from '../plugins/emojis';

    export default {
        name: 'Dialog',
        data: () => ({
            emojiData: emojiData,
            emojiShow: false,
            input_message: '',
            dates: ''
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
                let filtered = _.filter(messages, message => {
                    return message.from === this.contact.id || message.from === this.user.id;
                });

                return _.groupBy(filtered, message => {
                    return this.$moment(message.created_at).startOf('day').format();
                });
            }
        },
        watch: {
            contact(contact) {
                this.$store.commit('messages/setMessages', {messages: []});
                this.$store.dispatch('messages/getMessages', {contact});
                this.$store.dispatch('messages/reedMessages', {contact});
            }
        },
        methods: {
            sendMessage() {
                this.$axios.post('/api/to/' + this.contact.id + '/messages',
                    {message: this.input_message})
                    .then((response) => {
                        this.$store.commit('messages/addMessages', {message: response.data.data});
                    })
                    .finally(() => {
                        this.input_message = '';
                    });
            },
            newLine(e) {
                this.input_message += '\n';
            },
            emojiClicked(emoji) {
                this.input_message += emoji;
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
            overflow-y: scroll;
            width: auto;
            height: 550px;

            &::-webkit-scrollbar-track {
                -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
                background-color: #F5F5F5;
                border-radius: 10px;
            }

            &::-webkit-scrollbar {
                width: 5px;
                background-color: #F5F5F5;
            }

            &::-webkit-scrollbar-thumb {
                border-radius: 10px;
                background-color: #B3D4FC;
                background-image: -webkit-linear-gradient(90deg,
                        rgba(255, 255, 255, .2) 25%,
                        transparent 25%,
                        transparent 50%,
                        rgba(255, 255, 255, .2) 50%,
                        rgba(255, 255, 255, .2) 75%,
                        transparent 75%,
                        transparent)
            }
        }

        &--list {
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            height: auto;
            padding-bottom: 40px;
            padding-left: 0 !important;
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

        &--textarea {
            textarea {
                max-height: 150px;
            }
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

    .sc-emoji-picker {
        max-height: 215px;
        box-shadow: 0px 7px 40px 2px rgba(148, 149, 150, 0.3);
        background: white;
        border-radius: 10px;
        outline: none;
        bottom: 90px;
        right: 20px;
        width: 95%;
        position: absolute;

        &.desktop {
            max-height: 600px;
            position: relative;
            right: 0;
            bottom: 0;
            width: 100%;
            background: none;

            &:after {
                content: none;
            }

            .sc-emoji-picker--content {
                max-height: 600px;
            }
        }

        &:after {
            content: "";
            width: 14px;
            height: 14px;
            background: white;
            position: absolute;
            bottom: -6px;
            right: 55px;
            transform: rotate(45deg);
            border-radius: 2px;
        }

        &--content {
            padding: 10px;
            overflow: auto;
            width: 100%;
            max-height: 195px;
            margin-top: 7px;
            box-sizing: border-box;
        }

        &--category {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;

            &-title {
                min-width: 100%;
                color: #B8C3CA;
                font-weight: 200;
                font-size: 13px;
                margin: 5px;
                letter-spacing: 1px;
            }
        }

        &--emoji {
            margin: 5px;
            width: 30px;
            line-height: 30px;
            text-align: center;
            cursor: pointer;
            vertical-align: middle;
            font-size: 28px;
            transition: transform 60ms ease-out, -webkit-transform 60ms ease-out;

            &:hover {
                transform: scale(1.4);
            }
        }
    }
</style>
