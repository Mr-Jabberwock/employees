<template>
<div class="employees-form">
    <div class="employees">
        <div v-for="employees in splitEmployees" :key="employees">
            <div class="card" v-for="employee in employees"  :key="employee.phone" >
                <div class="card-body" >
                    <h3>{{employee.name}}</h3>
                    <b>{{employee.phone}}</b><br>
                    <b>{{employee.email}}</b><br>
                    <b>{{employee.position}}</b>
                </div>
            </div>
        </div>
    </div>
    <div >
        <form class="form">
            <div class="name form-group">
                <label for="name">Navn</label>
                <input v-bind:class="{red: nameFilled}" v-model="employee.name" type="text" class="form-control" id="name" placeholder="Navn">
            </div>
            <div class="email form-group">
                <label for="email">Email</label>
                <input v-bind:class="{red: emailFilled}" v-model="employee.email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Indtast email">
            </div>
            <div class="phone form-group">
                <label for="phone">Tellefon</label>
                <input v-bind:class="{red: phoneFilled}" v-model="employee.phone" type="phone" class="form-control" id="phone" placeholder="Tellefon">
            </div>
            <div class="position">
                <label for="position">Stilling</label>
                <select v-model="employee.position" class="form-select" id="position">
                    <option>Funktionær</option>
                    <option>Timelønnet</option>
                </select>
            </div>
         
            <button v-on:click="submit" type="button" class="btn btn-primary"><b>Gem</b><div class="loader" v-if="loading"></div></button>
        </form>
    </div>
</div>
</template>

<script>
    export default{

        data(){
           return {
               employee:{
                   name: "",
                   email: "",
                   phone: "",
                   position: "Funktionær"

               },
               employees: [],
               emailFilled: false,
               phoneFilled: false,
               nameFilled: false,
               loading: false
           }
        },
        computed:{
            //split the employees array into chunks of two. This allows us to have the array in a grid of two entries at a time
            splitEmployees(){
                return this.employees.reduce((acc, n, i) => {
                i % 2 ? acc[acc.length - 1].push(n) : acc.push([n])
                return acc
                }, [])
            }

        },
        methods:{
           submit(){
               //check each field individually. If they're not filled, set their outlines to be red
             if(this.employee.phone == ""){
                 this.phoneFilled = true
             }
             if(this.employee.name == ""){
                 this.nameFilled = true
             }
             if(this.employee.email == ""){
                 this.emailFilled = true
             }

             if(this.employee.name != "" && this.employee.phone != "" && this.employee.email != ""){
                this.loading = true;
                this.employees.push({name: this.employee.name, phone: this.employee.phone, email: this.employee.email, position: this.employee.position})
                axios.post('http://employees.test/employees', {name: this.employee.name, email: this.employee.email, phone: this.employee.phone, position: this.employee.position})
                .then((res)=>{
                    this.loading = false;
                    console.log(res)
                })
                
                //clean out the form so that it's reay to use again
                this.nameFilled = false
                this.emailFilled = false
                this.phoneFilled = false
                this.employee.name = "";
                this.employee.phone = "";
                this.employee.email = "";
                
             }
            /**/
           }
        },
        mounted() {
            axios.get('http://employees.test/employees').then((res)=> {
                res.data.forEach(element => {
                    console.log(element)
                    this.employees.push({name:element.name, email: element.email, phone: element.phone, position: element.position.position})
                });
            })
        }
    }
</script>

<style lang="scss">
.red{
    border-color: red;
}

.employees-form{
    height: 100%;
    overflow:hidden;
    .employees{
        margin-top: 20px;
        margin-bottom: 20px;
        max-height: 400px;;
        overflow: auto;

        .card{
            width: 50%;
            display: inline-flex;
    }
    }

    .form{
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(2, 1fr);
        grid-column-gap: 20px;
        grid-row-gap: 20px;

        .name { grid-area: 1 / 1 / 2 / 2; }
        .eamil { grid-area: 1 / 2 / 2 / 3; }
        .phone { grid-area: 2 / 1 / 3 / 2; }
        .position { grid-area: 2 / 2 / 3 / 3; }

    }

    .btn{
       display: flex;
       flex-direction: row;
       justify-content: space-between;
    }

    .loader {
        background-color: #0d6efd;
        border-top: 5px solid white;
        border-bottom: 5px solid white;
        border-left: 5px solid white;
        transform: translate(-50%, -50%);
        width: 25px;
        height: 25px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }


}


</style>