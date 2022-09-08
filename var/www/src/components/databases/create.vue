<template>
  <CForm v-on:submit.prevent="this.createDatabase()">
<h3>general info</h3>
<CInputGroup class="mb-3">
  <CInputGroupText id="basic-addon1">Database Name</CInputGroupText>
  <CFormInput placeholder="database name" aria-label="database_id" v-model="this.$data.form_data.database_name" aria-describedby="basic-addon1" required feedbackValid="Looks good!" @input="this.$data.form_data.database_id=(this.$data.form_data.database_name?this.$data.MD5(this.$data.form_data.database_name+(new Date())+this.$store.etc.company):'')"/>
</CInputGroup>

<CInputGroup class="mb-3">
  <CInputGroupText id="basic-addon1">Database ID</CInputGroupText>
  <CFormInput v-model="this.$data.form_data.database_id" aria-label="database_id" aria-describedby="basic-addon1" readonly/>
</CInputGroup>

<CInputGroup class="mb-3">
  <CInputGroupText id="basic-addon1">Date</CInputGroupText>
  <CFormInput aria-label="database_date" v-model="this.$data.form_data.date" aria-describedby="basic-addon1" readonly/>
</CInputGroup>

<CInputGroup class="mb-3">
  <CInputGroupText id="basic-addon1">User</CInputGroupText>
  <CFormInput v-model="this.$data.form_data.user" aria-label="database_user" aria-describedby="basic-addon1" readonly/>
</CInputGroup>

<h3>data fields</h3>
<CInputGroup class="mb-3">
<CButton color="success" v-on:click="this.$data.form_data.db_fields.push({});this.$data.field_count++;">+</CButton>
  <CButton color="danger" v-on:click="this.$data.form_data.db_fields.pop();this.$data.field_count--">-</CButton>

  <CInputGroupText id="basic-addon1">ID</CInputGroupText>
  <CFormInput placeholder="auto-generated" aria-label="field_id" aria-describedby="basic-addon1" disabled/>

  <CInputGroupText id="basic-addon1">entry date</CInputGroupText>
  <CFormInput placeholder="auto-generated" aria-label="field_date" aria-describedby="basic-addon1" disabled/>

  <CInputGroupText id="basic-addon1">user</CInputGroupText>
  <CFormInput placeholder="auto-generated" aria-label="field_user" aria-describedby="basic-addon1" disabled/>

</CInputGroup>


<CInputGroup class="mb-3" v-for="j in this.$data.field_count">
  <CInputGroupText id="basic-addon1" required>Field Name</CInputGroupText>
  <CFormInput placeholder="name" aria-label="field_name" v-model="this.$data.form_data.db_fields[j-1].name" aria-describedby="basic-addon1" required/>

  <CInputGroupText id="basic-addon1" >Field Type</CInputGroupText>
  <CFormSelect

  aria-label="field_type"
  :options="[
    { label: 'text', value: 'text' ,default: true},
    { label: 'number', value: 'number' },
    { label: 'date', value: 'date' },
  ]" v-model="this.$data.form_data.db_fields[j-1].type" required>
</CFormSelect>

  <CInputGroupText id="basic-addon1" >Field Default Value</CInputGroupText>
  <CFormInput placeholder="leave empty for none" aria-label="default" aria-describedby="basic-addon1" v-model="this.$data.form_data.db_fields[j-1].default"/>
</CInputGroup>

<CButton color="success" type="submit">Create Database</CButton>
</CForm>

</template>

<script>
import $ from "jquery";
export default {
  name: 'createDatabase',
  components: {
  },
  data() {
  return{
    form_data:{},
    MD5:require('md5'),
    NAMES:require('docker-names'),
    field_count:1,
  }
  },
  mounted() {
  },
  beforeUnmount() {
  },
  beforeCreated()  {
  },
  created()  {
    this.$data.form_data.date=new Date();
    this.$data.form_data.db_fields=[];
    this.$data.form_data.db_fields[0]={};
    this.$data.form_data.user=this.$store.etc.user.sub;
    this.$data.form_data.database_name=this.$data.NAMES.getRandomName();
    this.$data.form_data.database_id=(this.$data.form_data.database_name?this.$data.MD5(this.$data.form_data.database_name+(new Date())+this.$store.etc.company):'');
  },
  computed()  {
  },
  methods : {
    createDatabase(){
      this.$data.form_data.db_fields.forEach((field)=>{
        field.true_name=field.name;
        if(!field.type)
          field.type='text';
      });
      console.log(JSON.stringify(this.$data.form_data))
//    },
//    createDatabase(){
        var send={};
        send.token=this.$store.etc.token;
        send.path="/databases/create";
        send.data=this.$data.form_data;
        send=btoa(JSON.stringify(send));
      $.ajax({
        type: 'POST',
        data: send, 
        url: this.$store.etc.rest+"/bin/create/database",
        success:
        (response) =>
            {
              console.log(JSON.parse(atob(response)));
            },
        error:
        (response) =>
              {
              },
          async:false
          });
    }
  }
}
</script>
