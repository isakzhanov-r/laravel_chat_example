<template>
    <v-footer
            id="core-footer"
            absolute
            height="82">
        <v-content>
            <v-container fluid>
                <v-layout row wrap>
                    <div class="footer-items">
                        <span
                                v-for="link in links"
                                :key="link.name">
                            <a
                                    :href="link.Link"
                                    class="tertiary--text footer-links">{{ link.name }}</a>
                        </span>
                    </div>
                    <v-spacer/>
                    <span class="font-weight-light copyright">
      &copy;
      {{ (new Date()).getFullYear() }}
      <a
              href="https://avangard-hyundai.ru/"
              target="_blank">Avangard teem</a>, made with
      <v-icon
              color="tertiary"
              size="17">mdi-heart</v-icon>
      for a better web
    </span>
                </v-layout>
            </v-container>
        </v-content>
    </v-footer>
</template>

<script>
    export default {
        name: 'Footer',
        data: () => ({
            links: [
                {name: 'Home', Link: '/#'},
                {name: 'About Us', Link: 'https://creative-tim.com/presentation'},
                {name: 'Blog', Link: 'https://blog.creative-tim.com'}
            ]
        })
    };
</script>
