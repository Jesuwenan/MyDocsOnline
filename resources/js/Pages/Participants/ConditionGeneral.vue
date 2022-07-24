<template>

    <div class="bg-gray-100 h-full p-5">

        <div class="flex overflow-hidden">
        
            <div class="flex-1 overflow-auto focus:outline-none" tabindex="0">
                <div class="mt-5 flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
                    <div>
                        <img :src="baseUrl+'/img/logo.jpg'" class="rounded-full h-60 w-60">
                    </div>
                </div>
            </div>
        </div>

        <h1 class="w-full text-center m-8 font-bold">ABANDON DE RECOURS PARTICIPANTS (PILOTES ET CO-PILOTES)</h1>

        <div class="flex w-full">
            <div class="flex-1">
                <p class="m-5 text-justify">
                    Je déclare participer de ma propre initiative à l'épreuve décrite ci-dessus. <br>
                    Je déclare par la présente renoncer pour moi-même, mes ayants droits, mes héritiers, mes proches (mes parents, mon conjoint, mes enfants) et nos assureurs, à tous recours contre : <br>
                    1. Le ou les propriétaires et/ou exploitants du circuit, si l'épreuve a lieu sur circuit; <br>
                    2. Le ou les organisateurs de la manifestation; <br>
                    3. D'autres participants et, si l'épreuve a lieu sur circuit, d'autres utilisateurs dudit circuit; <br>
                    4. Les concurrents et les propriétaires (ou les détenteurs) des véhicules participants; <br>
                    5. Les préposés, aides bénévoles et chargés de mission de personnes (ou organismes) visées aux points 1,2, 3 et 4 ci-avant; <br>
                    6. Les assureurs des personnes (ou organismes) visées aux points 1, 2, 3, 4 et 5 ci-avant; <br>
                    
                </p>

                <!-- <div class="m-5">
                    <ol class=" list-decimal">
                    <li>Le ou les propriétaires et/ou exploitants du circuit, si l'épreuve a lieu sur circuit;</li>
                    <li>Le ou les organisateurs de la manifestation;</li>
                    <li>D'autres participants et, si l'épreuve a lieu sur circuit, d'autres utilisateurs dudit circuit;</li>
                    <li>Les concurrents et les propriétaires (ou les détenteurs) des véhicules participants;</li>
                    <li>Les préposés, aides bénévoles et chargés de mission de personnes (ou organismes) visées aux points 1,2, 3 et 4 ci-avant;</li>
                    <li>Les assureurs des personnes (ou organismes) visées aux points 1, 2, 3, 4 et 5 ci-avant;</li>

                    </ol>
                </div> -->

                

                <p class="m-5 text-justify">
                    Pour tous dommages que je subirais au cours de l'épreuve (y compris les entraînements). En cas de décès, le présent abandon de recours contient également engagement de porte-fort pour mes ayants droit, mes héritiers, mes proches et nos assureurs. <br>
                    Je déclare avoir pris connaissance des règlements qui régissent l'épreuve et m'engage à les respecter sans réserve.(1)  <br>
                    (1) Le Charnoy s’engage à respecter la vie privée des personnes qu’il rencontre dans le cadre de ses activités. Les « Données Personnelles » sont les informations qui identifient ou se rapportent à vous. Les « Données Personnelles » incluent par exemple (et sans s’y limiter), votre nom, vos adresses privées et professionnelles, numéro de téléphone, adresse email, et d’autres informations que vous nous communiquez.
                    Nous traitons vos données en conformité avec toutes les lois applicables concernant la protection des données et de la vie privée, en ce compris le « RGPD » - Règlement Général sur la Protection des Données (EU) 2016/679 (ci-dessous dénommées les « Lois de Protection des Données »). <br>
                    En s’enregistrant à un évènement du Charnoy, ou en fournissant d’une quelconque autre manière vos données au Charnoy, vous acceptez les termes de la présente déclaration de respect de la vie privée, ainsi que les traitements et les transferts de Données Personnelles conformément à cette déclaration de respect de la vie privée. <br>

                    Par le présent document, j’accorde au Charnoy, ses représentants et toute personne agissant comme  photographe ou du réalisateur mandaté par celui-ci, la permission irrévocable de publier toutes les photographies ou les images que vous avez prises de moi .
                </p>

                <p class="m-5 text-justify">
                  
                    Par le présent document, j’accorde au Charnoy, ses représentants et toute personne agissant comme  photographe ou du réalisateur mandaté par celui-ci, la permission irrévocable de publier toutes les photographies ou les images que vous avez prises de moi .
                </p>
            </div>
            

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