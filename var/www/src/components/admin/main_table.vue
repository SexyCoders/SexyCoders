<template>
  <CContainer>
    <CRow>
    <h3>
    <!--<font-awesome-icon icon="fas fa-database"/>-->
      <!--{{this.$data.run.database_obj.database_name}}-->
      <CButton color="success">new</CButton>{{" "}}
    <CButton color="warning">manage</CButton>{{" "}}
    <CButton color="secondary" v-on:click="this.getData(this.$store.etc.token)">refresh</CButton>
    </h3>
    <!--<a>(id={{this.$data.run.database_obj.database_id}})</a>-->
    </CRow>
    <CRow>
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
        >
        <!--<div slot="table-actions">-->
          <!--This will show up on the top right of the table.-->
        <!--</div>-->
      </vue-good-table>
    </CRow>
  </CContainer>
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
        tmp:{},
      },
    };
  },
  beforeCreated(){
  },
  created() {
    //this.$data.run.database_obj=this.$store.tmp.selected_database;
    //this.getDatabase(this.$store.etc.token);
  },
  methods : {
 // onRowClick(params){
 //     this.$data.selection=JSON.parse(JSON.stringify(this.$data.run.db_data.filter((row)=>{
 //       return row._id['$oid']===params.row.id
 //     },params)[0]));
 //   //console.log(this.$data.selection);
 //     var htmlstring='<center><table >';
 //       this.$data.selection['_id']=this.$data.selection['_id'].$oid;
 //       Object.keys(this.$data.selection).forEach((key)=>{
 //         htmlstring+='<tr><th>'+key+':</th> <td>'+this.$data.selection[key]+'</td></tr>';
 //       });
 //     htmlstring+='</table>';
 //     this.$swal.fire({
 //       icon: 'info',
 //       html:htmlstring,
 //       showConfirmButton: true,
 //       showCancelButton: true,
 //       focusConfirm: false,
 //       cancelButtonText:'<a>close</a>',
 //       confirmButtonText:'<a>edit</a>',
 //     }).then((e)=>{
 //       if(e.isDismissed)
 //         {  
 //         }
 //       else if(e.isConfirmed)
 //         {  
 //           this.onEdit();
 //         }
 //     });
 // },
 // onEdit(){
 //     var htmlstring='<center><table >';
 //     //console.log(this.$data.selection);
 //       Object.keys(this.$data.selection).forEach((key)=>{
 //         htmlstring+='<tr><th>'+key+':</th> <td><input id='+this.$data.selection["_id"]+key+' type="text" class="swal2-input" value="'+this.$data.selection[key]+'"></td></tr>';
 //       });
 //     htmlstring+='</table>';
 //       this.$swal.fire({
 //       icon: 'info',
 //       html:htmlstring,
 //       showConfirmButton: true,
 //       showCancelButton: true,
 //       showDenyButton: true,
 //       focusConfirm: false,
 //       cancelButtonText:'<a>close</a>',
 //       confirmButtonText:'<a>save</a>',
 //       denyButtonText:'<a>delete</a>',
 //       preConfirm: () => {
 //         this.$data.run.tmp.send_buffer=[];
 //         Object.keys(this.$data.selection).forEach((key)=>{
 //           console.log(this.$data.selection["_id"]+key);
 //           this.$data.run.tmp.send_buffer[key]=(document.getElementById(this.$data.selection["_id"]+key).value);
 //         });
 //         return 0;
 //       }
 //     }).then((e)=>{
 //       if(e.isDismissed)
 //         {  
 //         }
 //       else if(e.isConfirmed)
 //         {  
 //           //console.log("value check");
 //           //var t=JSON.stringify(e.value);
 //           //console.log(JSON.stringify(e))
 //           //console.log("t is "+t);
 //           //console.log(e.value);
 //           //this.onSave(e.value);
 //           //this.$data.run.test=JSON.parse(JSON.stringify(e.value));
 //           console.log(this.$data.run.tmp.send_buffer);
 //         var send={};
 //         //send.test="";
 //         send.token=this.$store.etc.token;
 //         send.data={};
 //         var t=Object.assign({},this.$data.run.tmp.send_buffer);
 //         send.data.id=t._id
 //         send.data.data=JSON.parse(JSON.stringify(t));
 //         delete send.data.data._id;
 //         send.path="/databases/"+this.$data.run.database_obj.database_id+"/UPDATE";
 //         //send.company=this.$store.etc.company;
 //         send=btoa(JSON.stringify(send));
 //         $.ajax({
 //           type: 'POST',
 //           data: send, 
 //           url: this.$store.etc.rest+"/serve",
 //           success:
 //           (response) =>
 //               {
 //                 var a=JSON.parse(atob(response));
 //                 //if(a.error)
 //                   //this.$onAuthError();
 //                 console.log(a);
 //                 //this.$swal.fire({
 //                 //  toast: true,
 //                 //  position: 'top-end',
 //                 //  showConfirmButton: false,
 //                 //  timer: 3000,
 //                 //  timerProgressBar: true,
 //                 //  icon: 'success',
 //                 //  title: 'updated successfully',
 //                 //  text: this.$data.selection._id
 //                 //})
 //               },
 //           error:
 //           (response) =>
 //                 {
 //                   this.$onAuthError();
 //                 },
 //             async:false
 //             });
 //             }
 //         });
 // },
 //   onSave(data){
 //     console.log(this.$data.run.test);
 //     console.log("test")
 //     console.log(data);
 //     //this.$data.tmp.data=JSON.parse(JSON.stringify(data));
 //     //this.$data.tmp.data=JSON.parse(JSON.stringify(data));
 //   },
  getData(token)
    {
      var send={};
      send.token=token;
      send.data="test";
      console.log("loading projects");
//      send.path="/databases/"+this.$data.run.database_obj.database_id+"/GET";
      send.pos=1;
      send.count=5;
//      send.company=this.$store.etc.company;
      send=btoa(JSON.stringify(send));
    $.ajax({
      type: 'POST',
      data: send, 
      url: this.$store.etc.rest+"/etc/projects",
      success:
      (response) =>
          {
          ////get response
            var a=JSON.parse(atob(response)).data;
           // console.log(a);

           // var t = JSON.parse(JSON.stringify(a));
           // console.log("t is >>>>>>>>> ");
           // console.log(t);
          ////store response
            this.$data.run.db_data=a;
          ////create object for current page
            var tt=[];
          ////only keep the fields needed for current page
            Object.values(a).forEach((obj)=>{
              var ttt={};
              ttt.ID=obj.project_id;
              ttt.Customer=obj.customer;
              ttt.Comments=obj.comment;
              ttt.Status=obj.status;
              tt.push(ttt);
              });

          ////create column title array
            this.$data.run.table_columns=[];
            Object.keys(tt[0]).forEach((key)=>{
              var t={};
              t.label=key;
              t.field=key;
                this.$data.run.table_columns.push(t)
              });
          ////create row data array of arrays
            this.$data.run.table_rows=[];
            //this.$data.run.database_obj.db_fields.forEach((field)=>{
              var t={};
              //t.label=field.name;
              //t.field=field.true_name;
              //t.type=field.type;
           //   this.$data.run.table_columns.push(t);
           // });
           // t.forEach((obj)=>{
           //   obj.id=obj['_id'].$oid;
           //   delete obj['_id'];
           // });
           // console.log(tt);
            Object.values(tt).forEach((row)=>{
              this.$data.run.table_rows.push(row);
              });
           //console.log(this.$data.run.table_rows);
          this.$data.run.table_rows=tt;
            console.log(tt);
          },
      error:
      (response) =>
            {
      //              this.$onAuthError();
      window.location.reload();
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
