import React, { useState } from 'react'
import SmallSpinner from '../Component/SmallSpinner'
import axios from 'axios';

function ChangePassword() {

    const [currentPassword, setCurrentPassword] = useState('');
    const [newPassword, setNewPassword] = useState('');
    const [confirmPassword, setConfirmPassword] = useState('');
    const [loader, setLoader] = useState(false);

    const changePassword = () => {

        if (newPassword !== currentPassword) {
            showToast('Passwords mismatch');
        }

        axios.post('/api/change-password?user_id=' + window.auth.id, { currentPassword, newPassword }).then((d) => {
            const { data } = d;
            if (data.message === false) {
                showToast('Current Password is Incorrect');
            }
        })
    }

    return (
        <div className="container">
            <div className="card p-5 mt-3">
                <div className="form-gorup">
                    <label htmlFor="">Enter Current Password</label>
                    <input type="password" className='form-control'
                        onChange={e => setCurrentPassword(e.target.value)} />
                </div>
                <div className="form-gorup mt-3">
                    <label htmlFor="">Enter New Password</label>
                    <input type="password" className='form-control'
                        onChange={e => setNewPassword(e.target.value)}
                    />
                </div>
                <div className="form-gorup mt-3">
                    <label htmlFor="">Confirm Password</label>
                    <input type="password" className='form-control'
                        onChange={e => setConfirmPassword(e.target.value)}
                    />
                </div>
                <div className='mt-3'>
                    <button className='btn btn-dark' onClick={() => changePassword()}>
                        {loader && <SmallSpinner />}

                        Change
                    </button>
                </div>
            </div>
        </div>
    )
}

export default ChangePassword