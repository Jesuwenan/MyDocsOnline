<template>
  <div class="mt-8">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
      <div class="px-4 sm:px-6 md:px-0">
        <div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
                        <div class="flex items-center">
                            <inertia-link class="text-3xl font-extrabold text-gray-900" :href="route('groups.index')">Groupes </inertia-link>
                        </div>
                    </li>

                    <li>
                        <div class="flex items-center">
                            <!-- Heroicon name: solid/chevron-right -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <a href="#" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" aria-current="page">Modifier un group</a>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="bg-white mb-3 rounded-lg shadow" >
          <div class="sm:hidden">
            <label for="tabs" class="sr-only">Select a tab</label>
            <select id="tabs" name="tabs" class="grid grid-flow-col grid-cols-3 grid-rows-3 gap-4 focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
              <option>Détails</option>
        ​
              <option>Fichiers</option>
        ​
              <option selected>Personnes</option>
        ​
            </select>
          </div>
          <div class="hidden sm:block">
            <div class="border-b border-gray-200">
              <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <!-- Current: "border-indigo-500 text-indigo-600", Default: "border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300" -->
                <a :set="err = 0" href="javascript:;" @click="chooseTab('details')" :class="currentTab == 'details' ? 'flex-1 border-indigo-500 text-indigo-600 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm' : 'flex-1 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm'">
                    <svg :class="currentTab == 'details' ? 'text-indigo-500 -ml-0.5 mr-2 h-5 w-5' : 'text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" stroke-width="2.5" fill="none"  linecap="round" stroke-linejoin="round" stroke="currentColor" aria-hidden="true">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/>
                        <path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/>
                    </svg>
                    <span>Détails</span>
                    <span v-for="i in ['name', 'phone', 'sponsor_id', 'dictionnary', 'dictionnary_version', 'protocol', 'custom_fields','email','price','invoice','price_recording','price_query','unique_term']" :key="i">
                        <span v-if="errors.hasOwnProperty(i)">
                        <span :set="err += 1"></span>
                        </span>
                    </span>
                    <span v-if="err > 0" class="bg-red-500 text-white hidden ml-3 py-0.5 px-2.5 rounded-full text-xs font-medium md:inline-block">
                        {{ err }}
                    </span>
                </a>
                
                <a href="javascript:;" @click="chooseTab('users')" :class="currentTab == 'users' ? 'flex-1 border-blue-500 text-blue-600 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm' : 'flex-1 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm'">
                    <svg xmlns="http://www.w3.org/2000/svg" :class="currentTab == 'users' ? 'text-blue-500 -ml-0.5 mr-2 h-5 w-6' : 'text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-6'" fill="none" viewBox="0 0 16 16" stroke="currentColor">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                    </svg>
                  <span class="self-center"> Membres </span>
                </a>

                <a href="javascript:;" @click="chooseTab('files')" :class="currentTab == 'files' ? 'flex-1 border-indigo-500 text-indigo-600 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm' : 'flex-1 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 group inline-flex items-center py-4 px-1 border-b-2 font-medium text-sm'">
                  <!-- Heroicon name: solid/office-building -->
                  <svg xmlns="http://www.w3.org/2000/svg" :class="currentTab == 'files' ? 'text-indigo-500 -ml-0.5 mr-2 h-5 w-5' : 'text-gray-400 group-hover:text-gray-500 -ml-0.5 mr-2 h-5 w-5'" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                  </svg>
                  <span>Fichiers</span>
                </a>
        
              </nav>
            </div>
          </div>
        </div>

        <div v-show="currentTab === 'details'" class="bg-white rounded shadow  w-full">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <div class="grid grid-cols-6 gap-6">

                        <div class="col-span-12 sm:col-span-6">
                            <label class="block text-sm font-medium text-gray-700" for="name">Nom du groupe *:</label>
                            <input v-model="form.name" name="name" id="name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" type="text"  />
                            <div v-if="errors.name" class="text-red-700 mt-2 text-sm">{{ errors.name }}</div>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Enregistrer</loading-button>
                </div>
            </form>
        </div>

        <div v-show="currentTab === 'users'" class="">
            <div class="mt-6 mb-2 sm:flex sm:items-center sm:justify-between" >
                <h3 class="text-xl font-extrabold text-gray-900">
                    Ajouter un membre 
                </h3>
            </div>
            <div class="rounded shadow w-full">
                <form @submit.prevent="submit">
                    <div class="px-4 py-5 bg-white sm:p-6" >
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label class="block text-sm font-medium text-gray-700">Utilisateur</label>
                                <Multiselect
                                    v-model="user.user"
                                    :options="users"
                                    track-by="id"
                                    :custom-label="userCustomLabel"
                                    label="name"/>
                                <div v-if="user_error" class="text-red-700 mt-2 text-sm">{{ user_error }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                        <loading-button @click.prevent="cancelUserForm()" :loading="false" class="ml-3 inline-flex  items-center justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-semibold uppercase rounded-md text-black bg-white hover:bg-transparent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-transparent" type="button">Annuler</loading-button>
                        <loading-button @click.prevent="linkUser()" :loading="false" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600" type="button">{{ ( edit_user )? "Save" : "Ajouter" }}</loading-button>
                    </div>
                </form>
            </div>
            

            <div class="mt-6 mb-2 sm:flex sm:items-center sm:justify-between" >
                <h3 class="text-xl font-extrabold text-gray-900">
                    Liste des membres
                </h3>
            </div>

            <div class="rounded shadow  w-full mt-3">
                <div class="w-full">
                    <table class="min-w-full divide-y divide-gray-200 ">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Utilisateurs
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Odd row -->
                            <tr v-for="(user, id) in form.users" :key="user.id" class="bg-white">
                                
                                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                    <button @click.prevent="editUser(user)" class="text-blue-600 hover:text-blue-900" style="display: inline">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button @click.prevent="unLinkUser(id)" class="text-blue-600 hover:text-blue-900" style="display: inline" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: inline">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ user.user.first_name + ' ' + user.user.last_name }}
                                </td>

                            </tr>
                            <tr v-if="form.users.length === 0" class="bg-white">
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium" colspan="7">Pas de membres</td>
                            </tr> 
                        </tbody>
                    </table>
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button @click="submit()" :loading="sending" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Save</loading-button>
                </div>
            </div>
        </div>

        <!--div class="bg-white rounded shadow overflow-hidden" v-show="currentTab==='files'">
            <form @submit.prevent="submit">
                <div class="px-4 py-5 bg-white sm:p-6">
                  
                    <div class="col-span-12 sm:col-span-12 pt-6">
                        <file-pond
                            name="file"
                            ref="pond"
                            label-idle="Glisser - Déposer les fichiers..."
                            v-bind:allow-multiple="true"
                            v-bind:required="false"
                            v-bind:files="myFiles"
                            accepted-file-types="image/jpeg, image/png, application/pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel, .csv"
                            server="/filepond/api/process"
                            v-on:init="handleFilePondInit"
                            :beforeRemoveFile="beforeRemove"
                            @processfile="processFile"
                            @removefile="removeFile"
                            @addfile="addFile"/>
                    </div>
                </div>
                <div class="px-8 py-4 bg-gray-100 border-t border-gray-200 flex justify-end items-center">
                    <loading-button :loading="sending" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" type="submit">Enregistrer</loading-button>
                </div>
            </form>
        </div-->

        
        <confirmation-dialog 
            v-if="showModal"
            :message="message"
            :show="show"
            :closeable="closeable"
            @confirm="confirm()"/>
        
        <!-- <treeselect v-model="" :multiple="true" :options="options" /> -->

      </div>
    </div>
  </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script>
import AppLayout from '@/Layouts/AppLayout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import Multiselect from 'vue-multiselect'
import ConfirmationDialog from '@/Shared/ConfirmationDialog'


import vueFilePond from 'vue-filepond';
import 'filepond/dist/filepond.min.css';

import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';

import 'filepond-plugin-image-pdf-overlay/dist/filepond-plugin-image-overlay.min.css';
import FilePondPluginImageOverlay from 'filepond-plugin-image-pdf-overlay';

import 'filepond-plugin-get-file/dist/filepond-plugin-get-file.min.css';
import FilePondPluginGetFile from 'filepond-plugin-get-file';

const FilePond = vueFilePond(
  FilePondPluginFileValidateType,
  FilePondPluginImageOverlay,
  FilePondPluginGetFile,
);

export default {
    components: {
        LoadingButton,
        TextInput,
        Multiselect,
        FilePond,
        ConfirmationDialog
    },
    props: {
        errors: Object,
        group: Object,
        files: Object
    },
    layout: AppLayout,
    data() {
        return {
            sending: false,
            user: {
                user: null,
            },
            edit_user: false,
            user_error: null,
            form: {
                _method: 'PUT',
                name: this.group.name,
                users: [],
                filepond_server_ids: []
            },
            user_id: '',
            changed: [],
            myFiles: [],
            filepond_server_ids: [],
            filepondFiles: [],
            message: 'Confirmer la suppression?',
            show:{
                default: true
            },
            closeable:{
                default: true
            },
            showModal: false,
            myPromise:null,
            indexToLink:null,
            fullScreenModalIsOpen: false,
            currentTab: 'details',

        }
    },
    mounted() {
        
        this.group.group_has_users.forEach(user => {
            let item = {
                user: user
            }
            this.form.users.push(item)
        })
    },
    created() {
        for (const file of this.files) {
            this.filepondFiles.push(file.name);
            this.myFiles.push({
                source: file.name,
                options: {
                type: 'limbo',
                },
            });
        }
        console.log(this.activities)
        //console.log(this.activities.changes.attributes.files)
    },
    methods: {
        chooseTab(tag) {
            this.currentTab = tag;
        },
        submit() {
            console.log(this.form)
            for (const [key, value] of this.filepondFiles.entries()) {
                this.form.filepond_server_ids.push(value);
            }

            this.form.filepond_server_ids = [...new Set(this.form.filepond_server_ids)];

            this.form.sponsor_id = this.sponsor_id.id

            this.$inertia.post(this.route('groups.update', this.group.id), this.form, {
                onStart: () => this.sending = true,
                onFinish: () => this.sending = false,
            })
        },
        linkUser()
        {
            if(this.user.user){

                let exist = false
                this.form.users.forEach(element => {
                    if(_.isEqual(element.user, this.user.user) && !this.edit_user)
                    {
                        this.user_error =  'This user has already been selected',

                        exist = true
                        return
                    }
                    else if(_.isEqual(element.user, this.user.user))
                    {
                        exist = true
                        this.edit_user = false
                        this.cancelUserForm()
                        return
                    }
                });

                if(!exist)
                {
                    this.form.users.push(this.user)
                    this.cancelUserForm()
                }

            }else{
                if(!this.user.user)
                    this.user_error = 'Select a user please'
                else
                    this.user_error = null
            }
            
        },
        unLinkUser(index)
        {
            this.form.users.splice(index, 1)
            this.cancelUserForm()

        },
        editUser(user){
            this.edit_user = true
            this.user = Object.assign({}, user)
        },
        cancelUserForm(){
            this.user = {
                user: null,
            }
            this.user_error = null
        },
        formatDate(date){
            return moment(date).fromNow()
        },
        removeOldFile(i) {
            this.form.old_files.splice(i, 1);
        },
        handleFilePondInit() {},
        async beforeRemove() {
            
            this.showModal = true
            this.show.default = true

            this.myPromise = new Promise((resolve, reject) => {
                window.onclick = function (event) {
                    if(event.target.id==='confirmDialog')
                        if(!this.showModal) {    
                            resolve('success');  
                        }else {    
                            reject('fail');  
                        }
                }
            });

            let result  = await this.myPromise

            if(result==='success')
                return true
            else
                return false
        },
        confirm()
        {
            this.showModal = false
            this.show.default = false            
            this.myPromise.then((value) => {
                return  value
            })
        },
        cancel(){
            this.showModal = false
            this.show.default = false 
            this.myPromise = null
        },
        processFile(e, f) {
            this.filepondFiles.push(f.serverId);
        },
        removeFile(e, f) {
            this.filepondFiles = this.filepondFiles.filter(e => e !== f.serverId);
        },
        addFile(e, f) {
        },
        selectInvoice(invoice){
            if (invoice==='Au temps réel') {
                this.form.price = 2
            }else{
                this.form.price = null
            }
        },
        removeInvoice(){
            this.form.price = null
        },
        setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            });
        },
        closeFullSreenModal(){
            this.fullScreenModalIsOpen = false
        },
        userCustomLabel(user) {
            return user.first_name + ' ' + user.last_name
        }
    },
    mounted(){
        this.setInputFilter(this.$refs.price, function(value) {
            return /^-?\d*[.]?\d*$/.test(value); 
        });
        this.setInputFilter(this.$refs.price_recoding, function(value) {
            return /^-?\d*[.]?\d*$/.test(value); 
        });
        this.setInputFilter(this.$refs.price_query, function(value) {
            return /^-?\d*[.]?\d*$/.test(value); 
        });
    }
    
}
</script>