<template>

    <div class="h-screen flex overflow-hidden bg-gray-100">
        
        <div class="flex-1 overflow-auto focus:outline-none" tabindex="0">
    
            <main class="flex-1 relative pb-8 z-0 overflow-y-auto">
                <flash-messages />
                <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                    <div>
                        <img :src="baseUrl+'/img/logo.jpg'" class="rounded-full h-60 w-60">
                        
                    </div>
                    
                    <!-- <p class="mt-3">
                        Au vu du nombre de participants à notre événement de ce 3 septembre 2021, nous avons dû inclure le Covid Safe Ticket. <br>
                        Nous vous rappelons donc que l’accès au site du Karting ne pourra se faire qu’à deux conditions : <br>
                        - d’avoir le QR code de l’événement qui vous sera envoyé ce mercredi 01/09/2021. <br>
                        <strong>ET</strong> <br>
                        - d’avoir votre Covid Safe Ticket qui reprend soit votre vaccination, soit un test PCR, soit un test antigénique fait en pharmacie. <br>
                    </p> -->
                </div>
            </main>
        </div>
    </div>
  
    

</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'
    import JetBanner from '@/Jetstream/Banner'
    import JetDropdown from '@/Jetstream/Dropdown'
    import JetDropdownLink from '@/Jetstream/DropdownLink'
    import JetNavLink from '@/Jetstream/NavLink'
    import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink'
    import FlashMessages from '@/Shared/FlashMessages'

export default {

    components: {
        JetApplicationMark,
        JetBanner,
        JetDropdown,
        JetDropdownLink,
        JetNavLink,
        JetResponsiveNavLink,
        FlashMessages      
    },
    props: {
        participant: Object,
        errors: Object,
    },
    data() {
        return {
            baseUrl: window.location.origin
        }
    },
    methods: {
    },
    
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>