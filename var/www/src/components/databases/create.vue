<template>
<h3>general info</h3>
<CInputGroup class="mb-3">
  <CInputGroupText id="basic-addon1">Database Name</CInputGroupText>
  <CFormInput placeholder="database name" aria-label="database_id" v-model="this.$data.form_data.db_name" aria-describedby="basic-addon1"/>
</CInputGroup>

<CInputGroup class="mb-3">
  <CInputGroupText id="basic-addon1">Database ID</CInputGroupText>
  <CFormInput :placeholder="this.$data.form_data.db_name?this.$data.MD5(this.$data.form_data.db_name+(new Date())+this.$store.etc.company):''" aria-label="database_id" aria-describedby="basic-addon1" disabled/>
</CInputGroup>

<CInputGroup class="mb-3">
  <CInputGroupText id="basic-addon1">Date</CInputGroupText>
  <CFormInput :placeholder="this.$data.date" aria-label="database_date" aria-describedby="basic-addon1" disabled/>
</CInputGroup>

<CInputGroup class="mb-3">
  <CInputGroupText id="basic-addon1">User</CInputGroupText>
  <CFormInput :placeholder="this.$store.etc.user.preferred_username" aria-label="database_user" aria-describedby="basic-addon1" disabled/>
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
  <CInputGroupText id="basic-addon1">Field Name</CInputGroupText>
  <CFormInput placeholder="name" aria-label="field_name" v-model="this.$data.form_data.db_fields[j].field_name" aria-describedby="basic-addon1"/>

  <CInputGroupText id="basic-addon1">Field Type</CInputGroupText>
  <CFormSelect
  aria-label="field_type"
  :options="[
    { label: 'text', value: 'text' },
    { label: 'number', value: 'number' },
    { label: 'date', value: 'date' },
  ]">
</CFormSelect>

  <CInputGroupText id="basic-addon1">Field Default Value</CInputGroupText>
  <CFormInput placeholder="leave empty for none" aria-label="field_default" aria-describedby="basic-addon1"/>
</CInputGroup>

<CButton color="success" v-on:click="this.createDatabase();">Create Database</CButton>
</template>

<script>
export default {
  name: 'createDatabase',
  components: {
  },
  data() {
  return{
    date:new Date(),
    form_data:{},
    MD5:require('md5'),
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
    this.$data.date=new Date();
    this.$data.form_data.db_name="";
    this.$data.form_data.db_fields=[];
    this.$data.form_data.db_fields[1]={};
  },
  computed()  {
  },
  methods : {
  }
}
</script>
