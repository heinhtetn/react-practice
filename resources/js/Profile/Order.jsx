import axios from 'axios';
import React, { useEffect, useState } from 'react'
import Spinner from '../Component/Spinner';

const Order = () => {

    const [loader, setLoader] = useState(true);
    const [order, setOrder] = useState({});
    const [page, setPage] = useState(1);

    useEffect(() => {
        const user_id = window.auth.id;
        axios.get(`/api/order-list?page=${page}&user_id=${user_id}`).then(({ data }) => {
            setOrder(data.data);
            setLoader(false);
        })
    }, [page]);

    return (
        <div>
            {loader && <Spinner />}
            {
                !loader && (
                    <>
                        <table className='table table-striped'>
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                {order.data.map((d) => (

                                    <tr key={d.id}>
                                        <td><img style={{ width: 100 }} src={d.product.image_url} /></td>
                                        <td>{d.product.name}</td>
                                        <td>{d.total_quantity}</td>
                                        <td>{d.product.sale_price} ks</td>
                                        <td>
                                            {
                                                d.status === 'cancel' &&
                                                (
                                                    <span className='badge badge-danger'>Cancelled</span>
                                                )
                                            }
                                            {
                                                d.status === 'success' &&
                                                (
                                                    <span className='badge badge-success'>Success</span>
                                                )
                                            }
                                            {
                                                d.status === 'pending' &&
                                                (
                                                    <span className='badge badge-warning'>Pending</span>
                                                )
                                            }

                                        </td>
                                    </tr>
                                ))}

                            </tbody>
                        </table>
                        <div className="p-3 text-center">
                            <button className='btn btn-dark' disabled={order.prev_page_url === null ? true : false}
                                onClick={() => setPage(page - 1)}
                            >
                                <i className='fa fa-arrow-left'></i>
                            </button>
                            <button className='btn btn-dark' disabled={order.next_page_url === null ? true : false}
                                onClick={() => setPage(page + 1)}
                            >
                                <i className='fa fa-arrow-right'></i>
                            </button>
                        </div>
                    </>

                )
            }

        </div >
    )
}

export default Order