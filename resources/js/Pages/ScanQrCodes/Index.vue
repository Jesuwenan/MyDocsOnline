<template>
  <div class="mt-8">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
      <div class="px-4 sm:px-6 md:px-0">
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div class="flex items-center">
                            <inertia-link class="text-3xl font-extrabold text-gray-900" :href="route('scan.qr.code.index')">Scan QR</inertia-link>
                        </div>
                    </li>

                </ol>
            </nav>
        </div>

        {{$page.props.csrf_token}}

        <div class="bg-white rounded shadow overflow-hidden">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="flex">

                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700" for="code">Barcode *:</label>
                            <input v-model="form.code" ref="code" name="code" id="code" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <!-- <div v-if="error_code" class="text-red-700 mt-2 text-sm">{{ error_code }}</div> -->
                        </div>

                        <div class="col-span-2 sm:col-span-1 mt-6">
                            <loading-button :loading="sending" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Vérifier QR</loading-button>
                        </div>

                    </div>
                </div>
               
            </form>
        </div>

        <div class="bg-white rounded shadow overflow-hidden mt-8" v-if="participant">

            <div class="px-4 py-5 bg-white sm:p-6">

                <div  v-if="!used" class="grid grid-cols-6 gap-6">
                    <div class="col-span-4 sm:col-span-2 mt-6">
                        <svg class="text-green-600" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 11 12 14 22 4"></polyline>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                    </div>
                    <div class="col-span-8 sm:col-span-4 mt-6">
                        <span><strong>Participant:</strong> {{ participant.person.last_name+" "+participant.person.first_name }}</span> <br>
                        <span><strong>Société:</strong> {{ participant.company.name }}</span> <br>
                        <span><strong>Evénement:</strong> {{ participant.event.name}} </span> <br>
                        <span><strong>Covid:</strong> {{participant.about_covid==='Test PCR' ? 'TEST PCR': 'VACCINE'}}  </span> <br>
                    </div>
                </div>

                <div v-else class="grid grid-cols-6 gap-6">
                    <div class="col-span-4 sm:col-span-2 mt-6">
                        <svg class="text-red-600" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="15" y1="9" x2="9" y2="15"></line>
                            <line x1="9" y1="9" x2="15" y2="15"></line>
                        </svg>
                    </div>
                    <div class="col-span-8 sm:col-span-4 mt-6">
                        <span><strong>Participant:</strong> {{ participant.person.last_name+" "+participant.person.first_name }}</span> <br>
                        <span><strong>Société:</strong> {{ participant.company.name }}</span> <br>
                        <span><strong>Evénement:</strong> {{ participant.event.name}} </span> <br>
                        <span><strong>Covid:</strong> {{participant.about_covid==='Test PCR' ? 'TEST PCR': 'VACCINE'}}  </span> <br>
                        <span><strong>Date d'utilisation:</strong> {{ participant.present}} </span> <br>
                    </div>

                </div>
            </div>

            <!-- <div class="flex justify-center mt-2">
                
                <p>
                    <span><strong>Participant:</strong></span> <br>
                    <span><strong>Société:</strong></span> <br>
                    <span><strong>Evénement:</strong></span> <br>
                </p>

            </div> -->

            <div class="flex justify-center mt-2">
            </div>

            <div class="flex justify-center mt-2">
            </div>

        </div>
        <loading v-model:active="sending"
          :can-cancel="false"
          :is-full-page="true"/>

      </div>
    </div>
  </div>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
    
    components: {
        LoadingButton,
        TextInput,
        SelectInput, 
        Loading,
    },
    props: {
    },
    layout: AppLayout,
    data() {
        return {
            sending: false,
            form: {
                code:null,
            },
            participant: null,
            used: null,
            selected: null,
            autocomplete: null,
        }
    },
    methods: {
        submit() {
            self = this
            this.participant = null
            this.used = null
            this.sending = true
            axios({
                method:'post',
                url:"/api/scan-qr-codes",
                data:{
                    code: this.form.code
                },
                // headers:{
                // 'Accept':'application/json',
                // 'Authorization':'Bearer '+window.localStorage.getItem('user-token')
                // }

            }).then((response)=>{
                this.participant = response.data.participant
                this.used = response.data.used
                this.sending = false
                this.error_code = null
                this.form.code = null
                  
            }).catch(function(error) {
                self.sending = false
                if(self.form.code===null)
                {
                    self.$toast.show( "Le champ barcode est obligatoire.",{
                        position: "top-right",
                        type: 'error',

                    })
                    //setTimeout(self.$toast.clear, 3000)
                    self.form.code = null
                }else{
                    self.$toast.show( "Le champ barcode scanné est invalide.",{
                        position: "top-right",
                        type: 'error',
                    })
                    //setTimeout(self.$toast.clear, 3000)
                    self.form.code = null
                }
                //console.log("erreur axios "+error);
            })
        },
        

      
    },
    mounted(){
        this.$refs.code.focus();
    }
    
    
}
</script>

