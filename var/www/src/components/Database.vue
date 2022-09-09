<template>
        <vue-good-table
      :columns="run.table_columns"
      :rows="run.table_rows"
      :line-numbers="true"
      styleClass="vgt-table condensed striped"
      :search-options="{
        enabled: true,
        placeholder: 'search',
      }"
      :pagination-options="{
        enabled: true,
        perPage: 10,
        perPageDropdown: [10, 20, 50, 100],
      }"
      v-on:row-click="onRowClick"
      />
</template>

<script>
import $ from "jquery";
import { VueGoodTable } from 'vue-good-table-next';
export default {
  name: 'MyTable',
  components: {
  VueGoodTable,
  },
  data(){
    return {
      run:{
        table_columns: [],
        table_rows: [],
        selection:'',
      },
    };
  },
  beforeCreated(){
  },
  created() {
    this.$data.run.database_obj=this.$store.tmp.selected_database;
    this.getDatabase(this.$store.etc.token);
  },
  methods : {
  onRowClick(params){
      this.$data.selection=this.$data.run.db_data.filter((row)=>{
        return row._id['$oid']===params.row.id
      },params)[0];
    console.log(this.$data.selection);
      var htmlstring='<center><table >';
        this.$data.selection['_id']=this.$data.selection['_id'].$oid;
        Object.keys(this.$data.selection).forEach((key)=>{
          htmlstring+='<tr><th>'+key+':</th> <td>'+this.$data.selection[key]+'</td></tr>';
        });
      htmlstring+='</table>';
      this.$swal.fire({
        icon: 'info',
        html:htmlstring,
        showConfirmButton: true,
        showCancelButton: true,
        focusConfirm: false,
        cancelButtonText:'<i class="fa fa-thumbs-down">close</i>',
        confirmButtonText:'<i class="fa fa-thumbs-up">edit</i>',
      }).then((e)=>{
        if(e.isDismissed)
          {  
          }
        else if(e.isConfirmed)
          {  
            this.onEdit();
          }
      });
  },
  onEdit(){
      var htmlstring='<center><table >';
      console.log(this.$data.selection);
        Object.keys(this.$data.selection).forEach((key)=>{
          htmlstring+='<tr><th>'+key+':</th> <td><input type="text" value="'+this.$data.selection[key]+'"/></td></tr>';
        });
      htmlstring+='</table>';
        this.$swal.fire({
        icon: 'info',
        html:htmlstring,
        showConfirmButton: true,
        showCancelButton: true,
        showDenyButton: true,
        focusConfirm: false,
        cancelButtonText:'<i class="fa fa-thumbs-down">close</i>',
        confirmButtonText:'<i class="fa fa-thumbs-up">save</i>',
        denyButtonText:'<i class="fa fa-thumbs-up">delete</i>',
      }).then((e)=>{
        if(e.isDismissed)
          {  
          }
        else if(e.isConfirmed)
          {  
            this.onSave();
          }
      });
  },
    onSave(){
      console.log("saving changes to entry "+this.$data.selection._id);
    },
  getDatabase(token)
    {
      var send={};
      send.token=token;
      send.data="test";
      send.path="/databases/"+this.$data.run.database_obj.database_id+"/GET";
      send.pos=1;
      send.count=5;
      send.company=this.$store.etc.company;
      send=btoa(JSON.stringify(send));
    $.ajax({
      type: 'POST',
      data: send, 
      url: this.$store.etc.rest+"/serve",
      success:
      (response) =>
          {
            var a=JSON.parse(atob(response)).data;
            var t = JSON.parse(JSON.stringify(a));
            this.$data.run.db_data=a;
            this.$data.run.database_obj.db_fields.forEach((field)=>{
              //var t=Object.keys(field);
              //console.log(t);
              var t={};
              t.label=field.name;
              t.field=field.true_name;
              t.type=field.type;
              this.$data.run.table_columns.push(t);
            });
            t.forEach((obj)=>{
              obj.id=obj['_id'].$oid;
              delete obj['_id'];
            });
            this.$data.run.table_rows=t;
//            this.$swal.fire({
//              title: 'Submit your Github username',
//              input: 'text',
//              inputAttributes: {
//                autocapitalize: 'off'
//              },
//              showCancelButton: true,
//              confirmButtonText: 'Look up',
//              showLoaderOnConfirm: true,
//              preConfirm: (login) => {
//                return fetch(`//api.github.com/users/${login}`)
//                  .then(response => {
//                    if (!response.ok) {
//                      throw new Error(response.statusText)
//                    }
//                    return response.json()
//                  })
//                  .catch(error => {
//                    Swal.showValidationMessage(
//                      `Request failed: ${error}`
//                    )
//                  })
//              },
//              allowOutsideClick: () => !Swal.isLoading()
//            }).then((result) => {
//              if (result.isConfirmed) {
//                Swal.fire({
//                  title: `${result.value.login}'s avatar`,
//                  imageUrl: result.value.avatar_url
//                })
//              }
//            });
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
<style scoped>
@import 'vue-good-table-next/dist/vue-good-table-next.css'
</style>
