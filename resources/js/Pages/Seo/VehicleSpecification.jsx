import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function VehicleModel(props) {
    return (
        <AuthenticatedLayout
            auth={props.auth}
            errors={props.errors}
            header={<h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{props.vehicleConstructor.designation + ' ' + props.vehicleModel.designation + ' ' + props.vehicleSpecification.designation}</h2>}
        >
            <Head title={props.vehicleConstructor.designation + ' ' + props.vehicleModel.designation + ' ' + props.vehicleSpecification.designation} />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 text-gray-900 dark:text-gray-100">
                            <div className="grid grid-cols-4 gap-4">
                                {props.vehicles.map((vehicle, index) => {
                                    return <div key={index} className="p-4 rounded-lg shadow-lg bg-emerald-800">
                                        {vehicle.designation}
                                        <a className="block text-xs" href={vehicle.url} target="_blank">
                                            {vehicle.url}
                                        </a>
                                    </div>
                                })}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
