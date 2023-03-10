export default {
    data(){
        return{
            company:'Shopfront Limited',
            editorData: '',
        }
    },
    computed:{
        data1 () {
            return '<ol>\n' +
                `    <li> <b> ${this.company} </b> will deduct all\n` +
                '      applicable withholding income Tax and VAT from the invoice at the time of payment as per Government rules.\n' +
                '      </li>\n' +
                '    <li>Payment will be made through the vendor’s Bank Account only.</li>\n' +
                `    <li> <b> ${this.company} </b> will deduct the\n` +
                '      actual amount in case of any damages of the premises during construction time and installation of the goods.</li>\n' +
                '\n' +
                '    <li> This price includes carrying, manual labor and any kind of charges thereof. </li>\n' +
                '    <li> Warranty: As per offer. </li>\n' +
                '    <li> The quality of work must be as per mentioned specification. </li>\n' +
                '    <li> Any type of sub-standard goods provided from your end, the Shopfront Limited or its entities reserves the right for outright rejection of the goods, which you will take back at your own cost\n' +
                '      and will replace with a new one within 10 days of the rejection date/ agreed time thereupon. </li>\n' +
                '    <li> Delivery Lead Time: Within 7 days days   <b> after receiving the WO or as per Shopfront Limited or its\n' +
                '      entities requirement.</b> For failing this schedule Tk.500.00 will be deducted for each day delay in delivery.</li>\n' +
                '\n' +
                '    <li> SFL or its entities reserves the rights of cancellation of\n' +
                '      work order without any prior notice for the non-compliance of any terms and conditions mentioned above.</li>\n' +
                '  </ol>'
        }
    },
    created(){
        console.log('ck helper file')
        this.editorData = this.data1;

    },
    methods:{
        getCompany(cost_center_id){
            axios.get(`/company/${cost_center_id}`)
                .then((response) => {
                    if(response.data){
                        this.company = response.data.name;
                        this.editorData = this.data1;
                    }
                }).catch((error) => {
                console.log(error);
            })
        }
    }
}
