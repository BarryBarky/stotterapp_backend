import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from '@inertiajs/react';

export default function AddUser({auth}) {
    const { data, setData, post, errors} = useForm({
        name: "",
        email: "",
        password: ""
    })

    function handleChange(e) {
        const key = e.target.id;
        const value = e.target.value
        setData(key, value)
    }



    function handleSubmit(e) {
        e.preventDefault()
        post('/dashboard/users', data)
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Alle Users |
                User Toevoegen</h2>}
        >
            <Head title="User Toevoegen"/>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 flex flex-col md:flex-row justify-between gap-10">
                            <section className="flex flex-col gap-10">
                                <section className={"flex flex-col gap-2"}>
                                    <label htmlFor="text">Naam:</label>
                                    <input id={"name"} type="text" style={{resize: 'none'}} value={data.name} onChange={handleChange} ></input>
                                    {errors.text && <div className={"text-red-500"}>{errors.text}</div>}
                                </section>
                                <section className={"flex flex-col gap-2"}>
                                    <label htmlFor="text">Email:</label>
                                    <input id={"email"}  type="text" style={{resize: 'none'}} value={data.email} onChange={handleChange}></input>
                                    {errors.text && <div className={"text-red-500"}>{errors.text}</div>}
                                </section>
                                <section className={"flex flex-col gap-2"}>
                                    <label htmlFor="text">Password:</label>
                                    <input id={"password"}  type="text" style={{resize: 'none'}} value={data.password} onChange={handleChange}></input>
                                    {errors.text && <div className={"text-red-500"}>{errors.text}</div>}
                                </section>
                                <button className={"w-fit bg-black text-white px-5 py-2 rounded"} type="submit">Toevoegen</button>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
