import Head from "next/head";

const AdminLoader = () => {
  if (typeof window !== "undefined") {
    const { HydraAdmin } = require("@api-platform/admin");
    return <HydraAdmin entrypoint={window.origin} />;
  }

  return <></>;
};

const Admin = () => (
  <>
    <Head>
      <title>Url shortener</title>
    </Head>

    <AdminLoader />
  </>
);
export default Admin;
