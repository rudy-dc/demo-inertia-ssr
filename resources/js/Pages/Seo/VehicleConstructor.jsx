import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function VehicleConstructor(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{props.vehicleConstructor.designation}</h2>}
        >
            <Head title={props.vehicleConstructor.designation} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <ul>
                                {props.vehicleModels.map((value, index) => {
                                    return <li key={index}>
                                        <a class="hover:underline" href={route('seo.vehicleModel', {vehicleConstructor: props.vehicleConstructor.slug, vehicleModel: value.slug})}>{value.designation}</a>
                                    </li>
                                })}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
