class TableList extends React.Component {
    constructor(props) {
        super(props);
    }

    eventShow = (e) => {
        let id = e.target.getAttribute('data-id');

        this.props.showModel(true, 'edit', id);
    }

    eventDetail = (e) => {
        let id = e.target.getAttribute('data-id');

        this.props.showModel(true, 'detail', id);
    }

    componentDidMount = () => {
    }

    onDelete = (e) => {
        let id = e.target.getAttribute('data-id');
        this.props.delete(id);
    }

    render() {
        return (
            <React.Fragment>
                <tr>
                    <td>{this.props.no}</td>
                    <td>{this.props.duit(this.props.data.total)}</td>
                    <td>{this.props.date(this.props.data.tanggal)}</td>
                    <td>
                        <button
                            type="button"
                            data-toggle="modal"
                            data-target="#modal-default"
                            className="btn btn-primary btn-sm mr-2"
                            data-id={this.props.data.id}
                            onClick={this.eventDetail}>Detail</button>
                        <button
                            type="button"
                            data-toggle="modal"
                            data-target="#modal-default"
                            className="btn btn-warning btn-sm mr-2"
                            data-id={this.props.data.id}
                            onClick={this.eventShow}>Edit</button>
                        {/* Role Reguler User : tidak bisa delete */}
                        {
                            this.props.role !== '2' ? 
                            <button className="btn btn-danger btn-sm mr-2" data-id={this.props.data.id} onClick={this.onDelete}>Delete</button>
                            :
                            ''
                        }
                    </td>
                </tr>
            </React.Fragment>
        )
    }
}

class MyBonus extends React.Component {
    constructor(props) {
        super(props);

        this.url  = $('meta[name="asset"]').attr('content');
        this.role = $('#role_id').val();

        this.state = {
            data: [],
            dataModal: [],
            isLoaded: false,
            show: false,
            modalType: null
        }

    }

    showHideModal = (text, type, id = null) => {
        if (id) {
            $.ajax({
                async: false,
                url: 'bonus/show',
                type: 'get',
                data: {
                    id: id
                },
                success: (xhr) => {
                    let datas = JSON.parse(xhr);
                    this.setState({ show: true, modalType: type, dataModal: datas });
                }
            })
        }
        else {
            this.setState({ show: text, modalType: type, dataModal: [] });
        }

    }

    componentDidMount = () => {
        this.loadData();
    }

    chaneFormatDate = (data) => {
        let format = new Date(data);


        let day = String(format.getDate()).padStart(2, 0);
        let month = String(format.getMonth() + 1).padStart(2, 0);
        let year = format.getFullYear();

        return `${day}-${month}-${year}`;
    }

    changeDuitRupiah = (duit) => {
        return new Intl.NumberFormat(
            'id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(duit);
    }

    

    loadData = async () => {
        try {
            let endpoint = await fetch('http://localhost/bonus_manager/bonus/data');

            if (!endpoint.ok) {
                throw new Error(`Error : ${endpoint.statusText}`);
            }

            let rst = await endpoint.json();
            this.setState({ data: rst, isLoaded: true }, () => {
                $('#table-bonus').DataTable({
                    destroy: true,
                    order: [],
                    columnDefs: [
                        { width: '5%', targets: 0, orderable: false, className: 'text-center' },
                        { width: '15%', targets: 1, orderable: false },
                        { width: '20%', targets: 2, orderable: false, className: 'text-center' },
                        { width: '20%', targets: 3, orderable: false, className: 'text-center' },
                    ]
                });
            });

        }
        catch (e) {
            console.log(e);
        }
    }

    onDelete = (id) => {
        Swal.fire({
            title: "Apakah anda yakin ?",
            text: "Ini tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'bonus/destroy',
                    type:'post',
                    data: {id: id},
                    dataType:'json',
                    success: (xhr) =>
                    {
                        if(xhr.status)
                        {
                            $("#table-bonus").DataTable().destroy();
                            this.loadData();
        
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Berhasil menghapus data bonus'
                            });
                        }
                    }
                })
            }
        });
    }

    onSave = (data) => {
        $.ajax({
            url: 'bonus/store',
            type: 'post',
            dataType: 'json',
            data: data,
            success: (xhr) => {
                if (xhr.status) {
                    $("#table-bonus").DataTable().destroy();
                    this.loadData();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Berhasil menambahkan bonus'
                    });
                }
            }
        })
    }

    onUpdate = (data) => {
        $.ajax({
            url: 'bonus/update',
            type: 'post',
            dataType: 'json',
            data: data,
            success: (xhr) => {
                if (xhr.status) {
                    $("#table-bonus").DataTable().destroy();
                    this.loadData();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Berhasil merubah bonus'
                    });
                }
            }
        })
    }

    render() {
        return (
            <>
                {/* Default box */}
                <div className="card card-dark">
                    <div className="card-header">
                        <h3 className="card-title" />
                        <div className="card-tools">
                            <button
                                type="button"
                                className="btn btn-default"
                                data-toggle="modal"
                                data-target="#modal-default"
                                onClick={() => this.showHideModal(true, 'add')}
                            >
                                <i className="fas fa-user-plus" />
                            </button>
                        </div>
                    </div>
                    <div className="card-body">
                        <table
                            id="table-bonus"
                            className="table table-bordered table-striped"
                            cellSpacing={0}
                            width="100%"
                        >
                            <thead className="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Bonus</th>
                                    <th>Tanggal</th>
                                    <th>
                                        <i className="fas fa-cogs" />
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {
                                    this.state.data.map((e, index) =>
                                        <TableList
                                            no={index + 1}
                                            key={e.id} data={e}
                                            duit={this.changeDuitRupiah}
                                            date={this.chaneFormatDate}
                                            showModel={this.showHideModal}
                                            delete={this.onDelete}
                                            role={this.role}
                                        />
                                    )
                                }
                            </tbody>
                        </table>
                    </div>
                    {/* /.card-body */}
                </div>
                {/* /.card */}

                {
                    this.state.show &&
                    <Modal
                        eventHide={this.showHideModal}
                        url={this.url}
                        eventSave={this.onSave}
                        eventUpdate={this.onUpdate}
                        modalType={this.state.modalType}
                        data={this.state.dataModal}
                        changeDuit={this.changeDuitRupiah}
                    />
                }
            </>

        )
    }
}

/** Modal Bonus */
class Modal extends React.Component {
    constructor(props) {
        super(props);
        this.title = '';
        this.buttonName = '';

        this.disabled = this.props.modalType === 'detail' ? true : false;

        if (props.modalType === 'edit' || props.modalType === 'detail') {
            this.state = {
                buruh: props.data.buruh || [{ name: 'Buruh A', percentase: '', amountBonus: '' }],
                totalNumberBonus: props.data.total_bonus || 0,
                formatTotalBonus: "Rp. " + props.data.total_bonus.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") || '',
                totalPercentase: props.data.total_persentase || 0,
                loading: false,
                dataModal: props.data,
                idBonus: props.data.id_bonus
            }
        }
        else if (props.modalType === 'add') {
            this.state = {
                buruh: [{ name: 'Buruh A', percentase: '', amountBonus: '' }],
                totalNumberBonus: 0,
                formatTotalBonus: '',
                totalPercentase: 0,
                loading: false,
            }
        }
    }

    configModalTitle = () => {
        switch (this.props.modalType) {
            case 'add':
                return this.title = 'Tambah Bonus';
                break;
            case 'edit':
                return this.title = 'Ubah Bonus';
            case 'detail':
                return this.title = 'Detail Bonus';
            default:
                break;
        }
    }

    configModalButton = () => {
        switch (this.props.modalType) {
            case 'add':
                return this.buttonName = 'Simpan';
                break;
            case 'edit':
                return this.buttonName = 'Ubah';
            case 'detail':
                return this.buttonName = '';
            default:
                break;
        }
    }

    onEventHide = () => {
        this.props.eventHide(false, 'Close');
    }

    eventSubmit = (e) => {
        e.preventDefault();

        if (this.state.totalPercentase < 100) {
            Swal.fire({
                icon: 'error',
                title: 'Ada masalah !',
                text: 'Pembagian bonus masih salah karena belum 100%'
            });

            return false;
        }
        else {
            this.setState({ loading: true });
            if (this.props.modalType === 'edit') {
                this.props.eventUpdate(
                    {
                        buruh: this.state.buruh,
                        totalNumberBonus: this.state.totalNumberBonus,
                        formatTotalBonus: this.state.formatTotalBonus,
                        totalPercentase: this.state.totalPercentase,
                        idBonus: this.state.idBonus
                    }
                );
            }
            else {
                this.props.eventSave(this.state);
            }

            this.setState({
                buruh: [{ name: '', percentase: 0, amountBonus: 0 }],
                totalNumberBonus: 0,
                formatTotalBonus: '',
                totalPercentase: 0
            });

            this.onEventHide();
            const backdrop = document.getElementsByClassName('modal-backdrop')[0];
            backdrop.parentNode.removeChild(backdrop);

            this.setState({ loading: false });

        }

    }

    onTotalBonusChange = (e) => {
        let raw = e.target.value.toString().replace(/[^\d]/g, '');
        let totalBonus = Number(raw);
        let totalFormated = "Rp. " + raw.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        this.setState({
            formatTotalBonus: totalFormated,
            totalNumberBonus: totalBonus
        })
    }

    calculateBonus = (percentase) => {
        const totalBonus = this.state.totalNumberBonus;
        let result = (percentase / 100) * totalBonus;
        if (!isNaN(result)) {
            return (percentase / 100) * totalBonus;
        }
        else {
            return 0;
        }
    }

    addBuruh = () => {
        const newBuruhName = this.generateBuruh(this.state.buruh.length);

        const newBuruh = { name: newBuruhName, percentase: '' };

        this.setState({ buruh: [...this.state.buruh, newBuruh] });
    }

    generateBuruh = (index) => {
        const alpha = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        const foo = alpha[index % alpha.length];

        return `Buruh ${foo}`;
    }

    componentDidUpdate(prevProps) {
        if (prevProps.data !== this.props.data) {
            const { total_bonus, buruh } = this.props.data;
            this.setState({
                totalNumberBonus: total_bonus,
                formatTotalBonus: "Rp. " + total_bonus.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."),
                buruh: buruh,
            });
        }
    }

    componentDidMount = () => {
    }

    handlePercentageChange = (index, event) => {
        const { buruh } = this.state;
        const updatedBuruh = [...buruh];
        let value = parseInt(event.target.value);
        if (!isNaN(value)) {
            let mantan = updatedBuruh[index].percentase;
            const totalPercentage = this.totalPercentage() - mantan + value;

            if (totalPercentage <= 100 || value < mantan) {
                if (totalPercentage === 100) {
                    $('#tambah_buruh').attr('disabled', true);
                }
                else {
                    $('#tambah_buruh').attr('disabled', false);
                }

                updatedBuruh[index].percentase = parseInt(event.target.value);
                updatedBuruh[index].amountBonus = this.calculateBonus(value);
                this.setState({ buruh: updatedBuruh, totalPercentase: totalPercentage });
            }
            else {
                $('#tambah_buruh').attr('disabled', true);
            }
        }
    }

    totalPercentage = () => {
        let percent = this.state.buruh.reduce((total, buruh) => total + buruh.percentase, 0);
        return percent;
    }

    render() {
        let colors = 'bg-dark';
        if (this.state.totalPercentase < 100) {
            colors = 'bg-danger';
        }
        else if (isNaN(this.state.totalPercentase)) {
            colors = 'bg-dark';
        }
        else {
            colors = 'bg-success';
        }

        return (
            <React.Fragment>
                <div
                    className="modal fade"
                    id="modal-default"
                    data-backdrop="static"
                    data-keyboard="false"
                >
                    <div className="modal-dialog">
                        <div className="modal-content">
                            <div className="modal-header bg-dark">
                                <h4 className="modal-title">{this.configModalTitle()}</h4>
                                <button
                                    type="button"
                                    className="close"
                                    data-dismiss="modal"
                                    aria-label="Close"
                                    onClick={this.onEventHide}
                                >
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div className="modal-body">
                                <form id="form" onSubmit={this.eventSubmit}>
                                    {/* Total Bayar Bonus */}
                                    <div className="form-group">
                                        <label htmlFor="fullname">Total Pembayaran Bonus <i class="fa fa-star text-danger" aria-hidden="true"></i></label>
                                        <input
                                            type="text"
                                            name="totalBonus"
                                            className="form-control"
                                            required
                                            disabled={this.disabled}
                                            placeholder="Masukan jumlah bonus yang akan dibagikan"
                                            value={this.state.formatTotalBonus}
                                            onChange={this.onTotalBonusChange}
                                        />
                                    </div>

                                    {/* Total Bayar Bonus */}
                                    <div className="form-group">
                                        {
                                            this.props.modalType === 'add' ?
                                                <button type="button" id="tambah_buruh" className="btn btn-sm btn-success" onClick={this.addBuruh}>Tambah Buruh</button>
                                                :
                                                ''
                                        }
                                        <badge className={`badge ${colors} m-2`}>{this.state.totalPercentase} %</badge>
                                        <hr />
                                        <ol>
                                            {
                                                this.state.buruh.map((e, i) =>
                                                    <div key={i} className="form-group row align-items-center" style={{ display: 'flex', alignItems: 'center' }}>
                                                        <label className="col-form-label col-sm-3" style={{ marginRight: '10px' }}>{e.name} &nbsp;
                                                            <i class="fa fa-star text-danger" aria-hidden="true"></i>

                                                        </label>
                                                        <div className="col-sm-3" style={{ marginRight: '10px' }}>
                                                            <input
                                                                type="number"
                                                                min="0"
                                                                required
                                                                disabled={this.disabled}
                                                                className="form-control"
                                                                value={e.percentase}
                                                                onChange={(event) => this.handlePercentageChange(i, event)}
                                                            />
                                                        </div>
                                                        <div className="col-form-label" style={{ marginRight: '10px' }}>%</div>
                                                        <div className="col-sm-4" style={{ marginRight: '10px' }}>
                                                            <input type="text" className="form-control"
                                                                disabled={this.disabled}
                                                                value={"Rp. " + this.calculateBonus(this.state.buruh[i].percentase).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}
                                                            />
                                                        </div>
                                                    </div>
                                                )
                                            }
                                        </ol>
                                    </div>

                                    <div className="modal-footer">
                                        {/* loading  */}
                                        {
                                            this.state.loading &&
                                            <div>
                                                <img src={`${this.props.url}images/icon/loading.gif`} />
                                                <span className="loading-text" />
                                            </div>
                                        }

                                        {
                                            this.props.modalType !== 'detail' ?
                                                <button type="submit" className="btn btn-primary">
                                                    {this.configModalButton()}
                                                </button>
                                                : ''
                                        }

                                        <button
                                            type="button"
                                            className="btn btn-default"
                                            data-dismiss="modal"
                                            id="close"
                                            onClick={this.onEventHide}
                                        >
                                            Tutup
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        {/* /.modal-content */}
                    </div>
                    {/* /.modal-dialog */}
                </div>

            </React.Fragment>
        )
    }
}

ReactDOM.createRoot(document.getElementById('bonus-content')).render(
    <React.StrictMode>
        <MyBonus />
    </React.StrictMode>
)