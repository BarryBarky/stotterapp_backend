import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from '@inertiajs/react';


export default function EditVariant({auth, variant}) {
    const { data, setData, put, errors} = useForm({
        name: variant.name,
    })

    function handleChange(e) {
        const key = e.target.id;
        const value = e.target.value
        setData(key, value)
    }

    function handleSubmit(e) {
        e.preventDefault()
        // console.log(data)
        put(`/dashboard/varianten/${variant.id}`, data)
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Alle Varianten |
                Variant Toevoegen</h2>}
        >
            <Head title="Level Toevoegen"/>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 flex flex-col md:flex-row justify-between gap-10">
                            <section className="flex flex-col gap-10">
                                <section className={"flex flex-col gap-2"}>
                                    <label htmlFor="name">Naam</label>
                                    <input id={"name"} type="text" value={data.name} onChange={handleChange}/>
                                    {errors.name && <div className={"text-red-500"}>{errors.name}</div>}
                                </section>
                                <button className={"w-fit bg-black text-white px-5 py-2 rounded"} type="submit">Opslaan</button>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
