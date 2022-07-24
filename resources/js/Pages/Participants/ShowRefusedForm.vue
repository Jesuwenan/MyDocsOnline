<template>

    <div class="h-screen flex overflow-hidden bg-gray-100">
        
        <div class="flex-1 overflow-auto focus:outline-none" tabindex="0">
    
            <main class="flex-1 relative pb-8 z-0 overflow-y-auto">
                <flash-messages />
                <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                    <div>
                        <img :src="baseUrl+'/img/logo.jpg'" class="rounded-full h-60 w-60">
                        
                    </div>                    
                    <div class="pt-6 rounded  overflow-hidden">
                        <form @submit.prevent="submit">
                            
                            <div class="px-8 py-4 flex justify-center items-center">
                                <loading-button :loading="sending" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-500 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" type="submit">Refuser l'invitation</loading-button>
                            </div>
                        </form>
                    </div>
                </div>
                
            </main>
        </div>
    </div>
  <!-- <div class="mt-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
      <div class="px-4 sm:px-6 md:px-0">
        <div class=" px-4 pb-5 sm:flex sm:items-center sm:justify-between">
            <p>
                Vous êtes invité pour l'événement <strong class="">{{participant.event.name}}</strong>  par l'entreprise : 
                <strong class="">{{participant.company.name}}</strong>
            </p>

            
        </div>

        <div class="bg-white rounded  overflow-hidden">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">


                       
                    </div>
                   
                </div>
                <div class="px-8 py-4 flex justify-center items-center">
                    <loading-button :loading="sending" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-400 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" type="submit">Confirmer mon invitation</loading-button>
                </div>
            </form>
        </div>


      </div>
    </div>
  </div> -->
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import VueMultiselect from 'vue-multiselect'
import FlashMessages from '@/Shared/FlashMessages'

export default {

    components: {
        LoadingButton,
        TextInput,
        SelectInput, 
        VueMultiselect,
        FlashMessages    
    },
    props: {
        participant: Object,
        errors: Object,
    },
    data() {
        return {
            baseUrl: window.location.origin,
            sending: false,
            form: {
                participant_id: this.participant.id,
            },
            selected: null,
            autocomplete: null,
            currentTab : 'details',

        }
    },
    methods: {
        submit() {
            
            this.$inertia.post(this.route('participants.refused'), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
                
            })
        }
    },
    mounted () {

    },
    
}
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>