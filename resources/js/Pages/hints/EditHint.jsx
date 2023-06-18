import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, useForm} from '@inertiajs/react';

export default function EditHint({auth, hint}) {
    const { data, setData, put, progress, errors} = useForm({
        text: hint.text,
        is_loop: hint.is_loop,
    })

    function handleChange(e) {
        const key = e.target.id;
        const value = e.target.value
        setData(key, value)
    }

    function handleSubmit(e) {
        e.preventDefault()
        put(`/dashboard/hints/${hint.id}`, data)
    }

    function handleCheckbox(e) {
        const key = e.target.id;
        const value = e.target.checked
        setData(key, value)
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Alle Hinten |
                Hint Bewerken</h2>}
        >
            <Head title="Level Toevoegen"/>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 flex flex-col md:flex-row justify-between gap-10">
                            <section className="flex flex-col gap-10">
                                <section className={"flex flex-col gap-2"}>
                                    <label htmlFor="text">Gesproken Tekst</label>
                                    <textarea id={"text"} rows={8} style={{resize: 'none'}} value={data.text} onChange={handleChange}></textarea>
                                    {errors.text && <div className={"text-red-500"}>{errors.text}</div>}
                                </section>
                                <section className={"flex flex-col gap-2"}>
                                    <label htmlFor="audio">Audio bestand</label>
                                    <input id={"audio"} accept=".mp3,audio/*" type="file"
                                           onChange={e => setData('audio', e.target.files[0])}/>
                                    {progress && (
                                        <progress value={progress.percentage} max="100">
                                            {progress.percentage}%
                                        </progress>
                                    )}
                                    {errors.audio && <div>{errors.audio}</div>}
                                </section>
                                <section className={"flex flex-col gap-2"}>
                                    <label htmlFor="is_loop">Zit het in de loop?</label>
                                    {data.is_loop ?
                                        <input type="checkbox" id="is_loop" checked={true} onChange={handleCheckbox}/>
                                        :
                                        <input type="checkbox" id="is_loop" checked={false} onChange={handleCheckbox}/>
                                    }

                                    {errors.is_loop && <div className={"text-red-500"}>{errors.is_loop}</div>}
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
