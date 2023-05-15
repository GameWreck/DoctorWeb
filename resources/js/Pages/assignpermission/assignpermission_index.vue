<script setup>
import Layout from '../layout.vue'
import Modal from '../components/modal.vue'
import { Head, router} from '@inertiajs/vue3'
import {  reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'
import Swal from 'sweetalert2/dist/sweetalert2.js'
import 'sweetalert2/dist/sweetalert2.min.css';

const  props = defineProps({
    roles:{
        type:Array,
        default: () => ([]),
    },
    permissions:{
        type:Array,
        default: () => ([]),
    },
});

const state = reactive({ showCreateModal: false, showModalRovek :false})

let form = useForm({
     permission:'Select',
     role:null
})

const successMessage=(message) => {
    Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: message,
        showConfirmButton: false,
        timer: 1500
    })
}

const openModalAssign = (id) => {
    state.showCreateModal=true;
    form.role=id;
}

const closeModalAssign = () => {
    state.showCreateModal=false;
    form.reset();
    form.clearErrors();
}

const assign = () => {
    form.post(route('dashboard.assignpermission.assign'), {
        preserveScroll: true,
        onSuccess: () => {
           closeModalAssign();
           successMessage('Permission Assigned Successfully');
        },
    })
    
}

const openModalRevoke = (id) => {
    state.showModalRovek=true;
    form.role=id;
}

const closeModalRevoke = () => {
    state.showModalRovek=false;
    form.reset();
    form.clearErrors();
}

const revoke = () => {
   form.delete(route('dashboard.assignpermission.revoke'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModalRevoke();
            successMessage('Permission Revoked Successfully')
        },
    })
}

const detail =(id) =>{
    router.get(route('dashboard.assignpermission.detail',id))
}


</script>

<template>
    <Head :title="'Assign Permission'"></Head>
    <Modal v-if="state.showCreateModal" :title="'Assign Permission'">
            <template #header>
                <button class="btn-close" @click="closeModalAssign"></button>
            </template>
            <template #body>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                        <div  class="col-sm-10">
                            <select  v-model="form.permission"  class="form-select"  aria-label="Default select example">
                                <option selected >Select</option>
                                <option v-for="(permission,index) in permissions" >{{ permission.name }}</option>
                             </select>
                             <span class="text-danger">{{ form.errors.permission }}</span>
                        </div>
                       
                    </div>
                   
            </template>
            <template #footer>
                <button type="button" @click="closeModalAssign" class="btn btn-dark">Close</button>
                <button @click="assign" type="submit" class="btn btn-primary" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        Assign
                </button>
            </template>
        </Modal>
        <Modal v-if="state.showModalRovek" :title="'Revoke Permission'">
            <template #header>
                <button class="btn-close" @click="closeModalRevoke"></button>
            </template>
            <template #body>
                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name</label>
                        <div  class="col-sm-10">
                            <select  v-model="form.permission"  class="form-select"  aria-label="Default select example">
                                <option selected  >Select</option>
                                <option v-for="(permission,index) in permissions"  >{{ permission.name }}</option>
                             </select>
                             <span class="text-danger">{{ form.errors.permission }}</span>
                        </div>
                    </div>
            </template>
            <template #footer>
                <button type="button" @click="closeModalRevoke" class="btn btn-dark">Close</button>
                <button @click="revoke" type="submit" class="btn btn-danger" :class="{ 'text-white-50': form.processing }" :disabled="form.processing">
                    <div v-show="form.processing" class="spinner-border spinner-border-sm" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        Revoke
                </button>
            </template>
        </Modal>
    <Layout>
        <div class="card __web-inspector-hide-shortcut__">
        <div class="card-header">
            <h4>Assign</h4>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                    <th>id</th>
                    <th>name</th>
                    <th>guard</th>
                    <th>created_at</th>
                    <th>updated_at</th>
                    <th>actions</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">
                    <tr v-for="(role,index) in roles">
                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{ role.id }}</strong></td>
                    <td>{{ role.name }}</td>
                    <td>{{ role.guard_name }} </td>
                    <td>{{ role.created_at }}</td>
                    <td >{{ role.updated_at }}</td>
                    <td>
                        <div class="row">
                            <div class="col-6 ">
                                <button @click="openModalAssign(role.id)" type="button"  class="btn btn-primary mx-1">Assign</button>
                                <button @click="openModalRevoke(role.id)" type="button"  class="btn btn-danger mx-1">Rollback</button>
                                <button @click="detail(role.id)" type="button"  class="btn btn-dark mx-1">All Permissions</button>
                            </div>
                        </div>
                    </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
    </Layout>
</template>