import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/react';
import {useEffect, useState} from "react";


export default function AddLevel({auth, variants, hints}) {
    const [checkboxes, setCheckboxes] = useState([]);
    useEffect(()=> {
        if (hints) {
            for (let i = 0; i<hints.length; i++) {
                setCheckboxes(checkboxes => [...checkboxes, {checked: false, value: hints[i].id}])
            }
        }
    }, [hints])
    const { data, setData, post, errors} = useForm({
        title: "",
        text: "",
        time: 5,
        variant_id: null,
        hints: []
    })

    function handleChange(e) {
        const key = e.target.id;
        const value = e.target.value
        setData(key, value)
    }

    function handleSubmit(e) {
        e.preventDefault()
        if (data.variant_id) {
            post('/dashboard/levels', data)
        }
    }

    function handleCheckboxChange(index) {
        checkboxes[index]['checked'] = !checkboxes[index]['checked'];
        setCheckboxes(checkboxes);
        setData("hints", checkboxes)
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Alle Levels |
                Level toevoegen</h2>}
        >
            <Head title="Level Toevoegen"/>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <form onSubmit={handleSubmit} className="p-6 flex flex-col gap-10">
                            <section className={"flex flex-col md:flex-row justify-between gap-20"}>
                                <section className="flex flex-col gap-10 w-full">
                                    <section className={"flex flex-col gap-2"}>
                                        <label htmlFor="title">Titel</label>
                                        <input id={"title"} type="text" value={data.title} onChange={handleChange}/>
                                        {errors.title && <div className={"text-red-500"}>{errors.title}</div>}
                                    </section>
                                    <section className={"flex flex-col gap-2"}>
                                        <label htmlFor="text">Gesproken tekst</label>
                                        <textarea id={"text"} rows={8} style={{resize: 'none'}} value={data.text} onChange={handleChange}></textarea>
                                        {errors.text && <div className={"text-red-500"}>{errors.text}</div>}
                                    </section>
                                </section>
                                <section className="flex flex-col gap-10 w-full">
                                    <section className={"flex flex-col gap-2"}>
                                        <label htmlFor="time">Tijd (in Seconden)</label>
                                        <input id={"time"} type="number" value={data.time} onChange={handleChange}/>
                                        {errors.time && <div className={"text-red-500"}>{errors.time}</div>}
                                    </section>
                                    <section className={"flex flex-col gap-2"}>
                                        <label htmlFor="variant_id">Welke variant?</label>

                                        {variants.length > 0 ?
                                            <select onChange={e => setData('variant_id', parseInt(e.target.value))} id="variant_id" >
                                                <option disabled selected>-</option>
                                                {variants.map((variant, index) => <option key={index} value={variant.id}>{variant.name}</option>)}
                                            </select>
                                            :
                                            <p className={"text-red-500"}>Geen varianten gevonden. Maak er eentje aan!</p>
                                        }
                                    </section>
                                    <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead
                                            className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th></th>
                                            <th scope="col" className="px-6 py-3">
                                                Gesproken tekst
                                            </th>
                                            <th scope="col" className="px-6 py-3">
                                                Zit het in de loop?
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        {
                                            hints.length > 0 ?
                                                hints.map((hint, index) =>
                                                    <tr key={index} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                        <td>
                                                            <input type="checkbox" id="hints" value={hint.id} onChange={() => handleCheckboxChange(index)}/>
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {hint.text}
                                                        </td>
                                                        <td className="px-6 py-4">
                                                            {hint.is_loop ? 'ja' : 'nee'}
                                                        </td>
                                                    </tr>
                                                )
                                                :
                                                <tr><td className={"text-red-500 px-6 py-4"}>Geen hints gevonden</td></tr>

                                        }
                                        </tbody>
                                    </table>
                                </section>
                            </section>
                            <section className={"flex flex-col gap-10 w-full"}>
                                <button className={"w-fit bg-black text-white px-5 py-2 rounded"} type="submit">Toevoegen</button>
                            </section>
                        </form>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
