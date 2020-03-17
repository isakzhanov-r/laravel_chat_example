<template>
    <v-app theme="dark">
        <v-img
                class="space"
                height="100%"
                width="100%"
        />

        <canvas id="space" class="space"/>

        <slot></slot>
    </v-app>
</template>

<script type="text/javascript">
    import space from '~client/plugins/space';

    export default {
        mounted() {
            this.initSpace();
        },

        methods: {
            initSpace() {
                space();
            }
        }
    };
</script>

<style lang="scss" scoped>
    @import "~vuetify/src/styles/settings/colors";

    .message {
        text-transform: lowercase;
        text-shadow: 0 1px 6px rgba(0, 0, 0, 0.75);
        animation: loading 1s infinite alternate;
        z-index: 1;
    }

    @keyframes loading {
        from {
            color: map-get($shades, 'white');
        }

        to {
            color: map-get($deep-purple, 'lighten-5');
        }
    }

    .layout {
        margin: -12px !important;
        width: calc(100% + 24px) !important;
        height: calc(100% + 24px) !important;
        max-width: calc(100% + 24px) !important;
        overflow: hidden !important;
    }

    .space {
        position: absolute;
    }
</style>
