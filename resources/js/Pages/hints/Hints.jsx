import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import {Head, Link, useForm} from '@inertiajs/react';

export default function Hints({auth, hints}) {
    console.log(hints)

    const { delete: destroy } = useForm()

    const onDelete = (id) => {
        destroy(`/dashboard/hints/${id}`)
    }

    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Alle
                Hints</h2>}
        >
            <Head title="Alle Hinten"/>

            <div className="py-12 px-10">
                <div className="flex flex-col gap-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                        <div className="relative overflow-x-auto">
                            <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    className="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" className="px-6 py-3">
                                        Gesproken tekst
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                {
                                    hints.length > 0 ?
                                        hints.map((hint, index) =>
                                            <tr key={index} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                                <td className="px-6 py-4">
                                                    {hint.text}
                                                </td>
                                                <td className={"flex gap-5 justify-end px-6 py-4"}>
                                                    <Link href={`/dashboard/hints/${hint.id}/bewerken`}>
                                                        <a className={"underline"}>Bewerken</a>
                                                    </Link>
                                                    <a className={"hover underline"} onClick={() => onDelete(hint.id)}>Verwijderen</a>
                                                </td>
                                            </tr>
                                        )
                                        :
                                        <tr><td className={"text-red-500 px-6 py-4"}>Geen hints gevonden</td></tr>

                                }

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <Link href={route('addHint')}>
                        <button className={"py-2 px-5 bg-black rounded text-white"}>
                            Toevoegen
                        </button>
                    </Link>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
